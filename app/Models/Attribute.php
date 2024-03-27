<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeCategory;
use App\Models\variationAttribute;
use App\Models\ProductAttribute;

class Attribute extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'att_cat_id', 'attribute','image','small_description'
    ];
	public $timestamps=false;
	
	public function category()
    {
		return $this->BelongsTo(AttributeCategory::class, 'att_cat_id', 'id');
    }
	
	public function variationAttribute()
    {
		return $this->hasManyThrough(VariationAttribute::class, ProductAttribute::class,'attr_id','product_attribute_id','id','id');
	}
}
