<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Attribute;

class ProductAttribute extends Model
{
    use HasFactory;
	protected $primaryKey = 'id';
	 protected $fillable = [
        'prod_id', 'attr_id','attr_order'
    ];
   protected $attributes = [
       'attr_order' => 1,
    ];
	
	public function product()
	{
		return $this->BelongsTo(Product::class,'prod_id','id');
	}
	
    public function attribute()
    {
		return $this->BelongsTo(Attribute::class, 'attr_id', 'id');

    }
}
