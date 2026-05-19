<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,SoftDeletes;

	 protected $fillable = [
        'name', 'parent_cat_id'
    ];
   protected $attributes = [
       'parent_cat_id' => 0,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Category $category) {
            if (! empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function category()
    {
		return $this->belongsTo(Category::class, 'parent_cat_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
