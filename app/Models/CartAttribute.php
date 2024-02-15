<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
use App\Models\ProductAttribute;


class CartAttribute extends Model
{
	 
    use HasFactory;

	 protected $fillable = [
        'cart_item_id', 'product_attribute_id'
    ];
	

	public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

   

}
