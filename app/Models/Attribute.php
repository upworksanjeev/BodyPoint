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
	
	public function category()
    {
       
		return $this->belongsTo('App\Models\AttributeCategory', 'att_cat_id', 'id');

    }
}
