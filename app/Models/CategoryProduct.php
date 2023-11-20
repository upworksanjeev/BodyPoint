<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Category;
use App\Models\Product;

class CategoryProduct extends Pivot
{
    use HasFactory;

	 protected $fillable = [
        'category_id', 'product_id'
    ];

		public function category()
		{
			return $this->BelongsTo(Category::class);
		}

		public function product()
		{
			return $this->BelongsTo(Product::class);
		}

}
