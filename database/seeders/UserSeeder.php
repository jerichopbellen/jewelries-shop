<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name'       => "Customer " . $i,
                'email'      => "customer" . $i . "@test.com",
                'password'   => Hash::make('password123'),
                'role'       => 'customer',
                'image_path' => null,
            ]);
        }
    }
}