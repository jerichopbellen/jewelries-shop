<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\ProductsDataTable;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $product = Product::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        // Update product fields
        $product->update($validated);

        // Handle removal of existing images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    // Delete file from storage
                    if ($image->image_path !== 'placeholders/product.png') {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    // Delete record from database
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images from storage and DB
        foreach ($product->images as $image) {
            if ($image->image_path !== 'placeholders/product.png') {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return back()->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was a problem importing your file: ' . $e->getMessage());
        }
    }
}