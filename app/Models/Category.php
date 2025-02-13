<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

	 protected $fillable = [
        'name', 'parent_cat_id'
    ];
   protected $attributes = [
       'parent_cat_id' => 0,
    ];

    public function category()
    {
		return $this->belongsTo(Category::class, 'parent_cat_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
