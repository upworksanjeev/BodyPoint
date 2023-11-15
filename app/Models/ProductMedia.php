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
	protected $attributes = [
       'media_type' => 'Image',
    ];		
		public function product()
		{
			return $this->BelongsTo(Product::class,'prod_id','id');
		}
}
