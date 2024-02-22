<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProduct;
use App\Models\ProductAttribute;
use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

	 protected $fillable = [
        'name','slug', 'sku', 'msrp', 'price', 'discount', 'product_type','small_description','description','overview','sizing','instruction_of_use','warranty','video'
    ];
	protected $attributes = [
       'product_type' => 'Single',
     
    ];

	protected static function boot() {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->name);
        });
    }
	
	public function attribute()
    {
        return $this->hasMany(ProductAttribute::class, 'prod_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-image');
    }

}
