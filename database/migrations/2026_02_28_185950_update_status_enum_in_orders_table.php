<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'pending',
            'processing',
            'shipped',
            'completed',
            'cancelled'
        ) DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Roll back to the previous set of values (adjust if needed)
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'pending',
            'completed',
            'cancelled'
        ) DEFAULT 'pending'");
    }
};