<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock'];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id'   => (int) $this->id,
            'name' => $this->name,
        ];
    }
}
