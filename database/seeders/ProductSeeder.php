<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage; // Make sure to import this

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $cat) {
            for ($i = 1; $i <= 5; $i++) {
                // 1. Create the Product
                $product = Product::create([
                    'category_id' => $cat->id,
                    'name'        => "Premium " . $cat->name . " " . $i,
                    'description' => "Handcrafted luxury " . strtolower($cat->name),
                    'price'       => rand(200, 5000),
                    'stock'       => rand(10, 100)
                ]);

                // 2. Create the related Product Image
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'placeholders/product.png'
                ]);
            }
        }
    }
}