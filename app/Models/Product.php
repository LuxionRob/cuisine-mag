<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'photo',
        'number_in_stock',
        'number_of_purchases',
        'rate_point',
        'store_id'
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
