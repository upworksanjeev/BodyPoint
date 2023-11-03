<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Category extends Model
{
    use HasFactory;
	
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
}
