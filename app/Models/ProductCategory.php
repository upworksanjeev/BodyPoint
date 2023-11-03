<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;

class ProductCategory extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'cat_id', 'prod_id'
    ];
	
		public function category()
		{
			return $this->belongsTo('Category', 'cat_id', 'id');
		}
		
		public function product()
		{
			return $this->belongsTo('Product', 'prod_id', 'id');
		}
}
