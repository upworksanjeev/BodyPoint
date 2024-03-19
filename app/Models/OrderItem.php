<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderAttribute;
use App\Models\Product;


class OrderItem extends Model
{
    use HasFactory;

	 protected $fillable = [
        'order_id', 'product_id','price','quantity','discount','discount_price','marked_for','sku','variation_id','msrp'
    ];
	
	public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
	
	public function orderAttribute()
    {
        return $this->hasMany(OrderAttribute::class);
    }

  

}
