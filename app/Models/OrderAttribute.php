<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\ProductAttribute;


class OrderAttribute extends Model
{
	 
    use HasFactory;

	 protected $fillable = [
        'order_item_id', 'product_attribute_id'
    ];
	

	public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

   

}
