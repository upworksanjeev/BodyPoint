<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\CartAttribute;
use App\Models\Product;


class CartItem extends Model
{
    use HasFactory;

	 protected $fillable = [
        'cart_id', 'product_id','price','quantity','discount','discount_price'
    ];
	

	public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
	
	public function cartAttribute()
    {
        return $this->hasMany(CartAttribute::class);
    }

  

}
