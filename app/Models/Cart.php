<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
use App\Models\User;


class Cart extends Model
{
    use HasFactory;

	 protected $fillable = [
        'user_id', 'total_items'
    ];
	

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }

  

}
