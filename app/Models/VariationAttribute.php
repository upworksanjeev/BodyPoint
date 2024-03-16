<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variation;
use App\Models\ProductAttribute;


class VariationAttribute extends Model
{
	 
    use HasFactory;	
	 protected $fillable = [
        'variation_id', 'product_attribute_id'
    ];
	

	public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

   

}
