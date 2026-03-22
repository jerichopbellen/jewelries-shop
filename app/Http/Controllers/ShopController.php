<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Mail\OrderPlaced;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
{
    /**
     * Display the product catalog.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if (!empty($search)) {
            $products = Product::search($search);
        } else {
            $products = Product::query();
        }

        $products = $products->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category);
            })
            ->when($minPrice !== null, function ($query) use ($minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice !== null, function ($query) use ($maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->simplePaginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        // Load relations for the specific product
        $product->load(['category', 'images']);

        // Get related products (same category) for "You May Also Like"
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    /**
     * Add a product to the current user's cart (simplified).
     */
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        $cartItemKey = $product->id;

        if (isset($cart[$cartItemKey])) {
            $cart[$cartItemKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartItemKey] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => $request->quantity,
                'image'      => $product->images->first()
                                ? $product->images->first()->image_path
                                : null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} added to cart.");
    }

    /**
     * Show the user's cart.
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('shop.cart', compact('cart'));
    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('shop.cart')->with('success', "{$product->name} removed from cart.");
    }

    public function checkoutForm()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('shop.checkout', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return back()->with('error', 'Your cart is empty.');

        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,gcash,card',
        ]);

        $order = DB::transaction(function () use ($cart, $request) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'GLW-' . strtoupper(Str::random(8)),
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            return $order;
        });

        // Generate PDF Receipt
        $order->load('items.product', 'user');
        $pdf = Pdf::loadView('emails.receipt_pdf', compact('order'));

        // Send Email with Attachment
        Mail::to($order->user->email)->send(new OrderPlaced($order, $pdf->output()));

        session()->forget('cart');

        return redirect()->route('shop.index')->with('success', 'Order placed successfully! Check your email for the receipt.');
    }

    public function ordersIndex()
    {
        // Get only the authenticated user's orders
        $orders = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->with('items.product')   // eager load items and products
            ->latest()
            ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function ordersShow(Order $order)
    {
        // Ensure the customer can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('items.product');

        return view('shop.orders.show', compact('order'));
    }

    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->whereIn('status', ['Delivered', 'cancelled']) // only completed & cancelled
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('shop.orders.history', compact('orders'));
    }

    public function cancel(Order $order)
    {
        // Ensure the order belongs to the user and hasn't been shipped yet
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $restrictedStatuses = ['shipped', 'delivered', 'cancelled'];
        
        if (in_array(strtolower($order->status), $restrictedStatuses)) {
            return back()->with('error', 'This order cannot be cancelled as it is already ' . $order->status . '.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Your order has been successfully cancelled.');
    }

}