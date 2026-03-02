<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'order_number', 'phone', 'address', 'city', 'province', 'postal_code', 'country', 'payment_method', 'status'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->reduce(fn($total, $item) => $total + ($item->price * $item->quantity), 0);
    }
}