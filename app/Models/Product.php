<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProduct;
use App\Models\ProductMedia;
use App\Models\ProductAttribute;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'name', 'product_type'
    ];
	protected $attributes = [
       'product_type' => 'Single',
    ];
	
	 public function category()
    {
        return $this->hasMany(CategoryProduct::class, 'product_id', 'id');
    }
	
	public function media()
    {
        return $this->hasMany(ProductMedia::class, 'prod_id', 'id');
    }
	
	public function attribute()
    {
        return $this->hasMany(ProductAttribute::class, 'prod_id', 'id');
    }
	

}
