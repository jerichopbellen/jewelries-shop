<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\OrdersDataTable;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('admin.orders.index');
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // 1. DEDUCT STOCK: Only when moving from 'processing' to 'shipped'
        if ($oldStatus === 'processing' && $newStatus === 'shipped') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    // Safety Check: Ensure we have enough stock before proceeding
                    if ($item->product->stock < $item->quantity) {
                        return back()->with('error', "Insufficient stock for {$item->product->name}. Current stock: {$item->product->stock}");
                    }
                    
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        }

        // 2. RESTORE STOCK: If a shipped order is cancelled
        if ($oldStatus === 'shipped' && $newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Apply the update
        $order->update(['status' => $newStatus]);

    // PREPARE PDF FOR ATTACHMENT
    $order->load('items.product', 'user');
    $pdf = Pdf::loadView('emails.receipt_pdf', compact('order'));

    // SEND EMAIL WITH PDF
    if ($order->user) {
        Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $pdf->output()));
    }

        return back()->with('success', 'Order status updated to ' . ucfirst($newStatus));
    }
}