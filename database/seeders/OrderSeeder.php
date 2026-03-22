<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::where('role', 'customer')->get();

        if ($users->isEmpty()) {
            $this->command->error("No customers found. Run UserSeeder first!");
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            $date = Carbon::now()->subMonths(rand(0, 36))->subDays(rand(0, 28));
            $user = $users->random();

            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => (string) Str::uuid(),
                'address'        => 'Sample Street Address ' . rand(1, 100),
                'city'           => 'Taguig City',
                'province'       => 'Metro Manila',
                'postal_code'    => '1634',
                'country'        => 'Philippines',
                'phone'          => '09123456789',
                'payment_method' => 'cod',
                'status'         => 'delivered',
                'created_at'     => $date,
                'updated_at'     => $date
            ]);

            // Create 1-3 items for this order
            $itemsCount = rand(1, 3);
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => rand(1, 2),
                    'price'      => $product->price,
                    'created_at' => $date
                ]);
            }
        }
    }
}