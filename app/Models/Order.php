<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;


class Order extends Model
{
    use HasFactory;

	 protected $fillable = [
        'user_id', 'total_items', 'purchase_order_no'
    ];
	

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

  

}
