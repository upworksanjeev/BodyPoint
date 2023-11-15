<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeCategory;

class Attribute extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'att_cat_id', 'attribute'
    ];
	public $timestamps=false;
	
	public function category()
    {
		return $this->BelongsTo(AttributeCategory::class, 'att_cat_id', 'id');
    }
}
