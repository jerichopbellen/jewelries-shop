<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class ProductsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();
        $placeholder = 'placeholders/product.png';

        $categoryName = $data['category'] ?? 'Uncategorized';
        $productName  = $data['name'] ?? 'Unnamed Product';

        // 1. Create Category if it doesn't exist
        $category = Category::firstOrCreate(['name' => trim($categoryName)]);

        // 2. Create Product
        $product = Product::firstOrCreate(
            [
                'category_id' => $category->id,
                'name'        => trim($productName),
            ],
            [
                'description' => $data['description'] ?? 'No description',
                'price'       => $data['price'] ?? 0,
                'stock'       => $data['stock'] ?? 0,
            ]
        );

        // 3. Handle Product Image (using placeholder)
        ProductImage::firstOrCreate([
            'product_id' => $product->id,
            'image_path' => $placeholder,
        ]);
    }
}