<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsTo(Category::class, 'cat_id', 'id');

    }
}
