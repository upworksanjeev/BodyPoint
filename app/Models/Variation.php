<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VariationAttribute;


class Variation extends Model
{
	 
    use HasFactory;
	
	 protected $fillable = [
        'product_id', 'name', 'sku', 'msrp','price','discount', 'sale_price'
    ];
	
	public function product()
    {
        return $this->belongsTo(Product::class);
    }
	
	public function variationAttribute()
    {
        return $this->hasMany(VariationAttribute::class);
    }


}
