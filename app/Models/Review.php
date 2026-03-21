<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    // Get the user who wrote the review
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get the product being reviewed
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}