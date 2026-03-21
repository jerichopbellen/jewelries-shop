<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Links the review to the customer
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Links the review to the specific jewelry piece
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Rating system (1-5 stars)
            $table->unsignedTinyInteger('rating')->default(5);
            
            // The customer's written feedback
            $table->text('comment')->nullable();
            
            $table->timestamps();

            // Optional: Prevents a user from leaving multiple reviews for the same product
            // $table->unique(['user_id', 'product_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};