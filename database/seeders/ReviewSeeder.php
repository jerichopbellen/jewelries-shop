<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error("No users found to write reviews!");
            return;
        }

        foreach ($products as $product) {
            // 50% chance a product gets a review
            if (rand(0, 1)) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id'    => $users->random()->id, // Picks a random user from the collection
                    'rating'     => rand(4, 5),
                    'comment'    => "Excellent quality and service!",
                    'created_at' => now()->subDays(rand(1, 20))
                ]);
            }
        }
    }
}