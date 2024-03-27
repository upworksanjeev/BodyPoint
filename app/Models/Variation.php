<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VariationAttribute;
use App\Models\Attribute;
use App\Models\AttributeCategory;


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
	
	public function attribute()
    {
		return $this->hasOneThrough(Attribute::class, ProductAttribute::class,'prod_id','id','product_id','attr_id');
	}


}
