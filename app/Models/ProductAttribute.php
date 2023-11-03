<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Attribute;

class ProductAttribute extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'prod_id', 'attr_id','attr_order'
    ];
   protected $attributes = [
       'attr_order' => 0,
    ];
	
	public function product()
    {
		return $this->belongsTo('Product', 'prod_id', 'id');
    }
	
    public function Attribute()
    {
		return $this->belongsTo('Attribute', 'attr_id', 'id');

    }
}
