<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductMedia extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'prod_id', 'media'
    ];
	
	public function product()
    {
		return $this->belongsTo('App\Models\Product', 'prod_id', 'id');
    }
}
