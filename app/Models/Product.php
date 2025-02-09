<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProduct;
use App\Models\ProductAttribute;
use App\Models\Category;
use App\Models\Variation;
use App\Models\SuccessStory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia , SoftDeletes;

	 protected $fillable = [
        'name','item_name','slug', 'sku', 'msrp', 'price', 'discount', 'product_type','small_description','description','overview','sizing','instruction_of_use','warranty','video'
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

	public function variation()
    {
        return $this->hasMany(Variation::class);
    }
	
	public function successStory()
    {
        return $this->hasMany(SuccessStory::class);
    }

}
