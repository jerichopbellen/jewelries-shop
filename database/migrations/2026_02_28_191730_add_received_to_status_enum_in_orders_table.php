<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'received' to the ENUM values
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'pending',
            'processing',
            'shipped',
            'received',
            'completed',
            'cancelled'
        ) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Roll back to the previous set of values (without 'received')
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'pending',
            'processing',
            'shipped',
            'completed',
            'cancelled'
        ) DEFAULT 'pending'");
    }
};