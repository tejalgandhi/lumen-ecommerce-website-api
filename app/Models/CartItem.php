<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $appends = ['total_price'];

    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getTotalPriceAttribute()
    {
        return $this->quantity * ($this->product ? $this->product->price : 0);
    }
}
