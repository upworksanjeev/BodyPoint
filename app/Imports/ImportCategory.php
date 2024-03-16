<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\AttributeCategory;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\Variation;
use App\Models\VariationAttribute;
use Illuminate\Support\Str;

class ImportCategory implements ToModel, WithHeadingRow
{
   
   public function model(array $row)
   {
	  
	  if(isset($row['item_name']) && $row['item_name']!=''){
		    if($row['item_type']=='SKU'){ $product_type="Option"; }else{ $product_type="Single";  }
			
			//check product exist or not
		   $product=Product::where('name',$row['item_name'])->where('product_type',$product_type)->first();
		   if(isset($product['id'])){
				   $product_id=$product['id'];
			   }else{
				  
				   //Add product
				   $product= Product::create([
					   'name' => $row['item_name'],
					   'slug' => Str::slug($row['item_name']),
					   'sku' => $row['model_stockcode']?trim($row['model_stockcode']):trim($row['stockcode']),
					   'product_type' => $product_type,
					   'is_deleted' => 0,
					   'overview' => $row['product_overviewoverview']??'',
					   'sizing' => $row['product_sizingsizing']??'',
					   'instruction_of_use' => $row['product_instructionsinstructions_for_use']??'',
				   ]);
				    
				   $product_id=$product['id'];
			   }
			   if($row['item_type']=='SKU'){ 
				   //Add Variation 
				   $variation= Variation::create([
					   'name' => trim($row['item_name']),
					   'product_id' => $product['id'],
					   'sku' => trim($row['stockcode']),
				   ]);
				   $variation_id=$variation['id'];
			   }
				   
			 if(isset($row['categories'])){
				   $cat_arr=explode(',',$row['categories']);
				   
				   if(count($cat_arr)>0){
				   //Add multiple category
				   foreach($cat_arr as $k=>$v){
					   //check category exist or not
						$cat=Category::where('name',trim($v))->first();
									
					   if(isset($cat['id'])){
						   $cat_id=$cat['id'];
					   }else{
						   
						   $cat= Category::create([
							   'name' => trim($v),
						   ]);
							$cat_id=$cat['id'];
						  
					   }
					   //check Category-product relation exist or not
						$catprod=CategoryProduct::where('category_id',$cat_id)->where('product_id',$product_id)->first();		   
					   //Add category_product relation
						if(!isset($catprod['id'])){
							$catprod=CategoryProduct::create(['category_id' => $cat_id,'product_id' => $product_id]);
						}
					}
				   }
			 }
		   foreach($row as $k=>$v){
			    if(str_contains($k,'attributes')){
					$attcat=str_replace("_",' ',str_replace('attributes','',$k));
					 //check attribute category exist or not
					$attribute_cat=AttributeCategory::where('category',$attcat)->first();
					if(!isset($attribute_cat['id'])){				
						$attribute_cat=AttributeCategory::create(['category' => $attcat]);
					}
					if($v!=''){
					//check attribute exist or not
						$attribute=Attribute::where('attribute',rtrim($v,';'))->where('att_cat_id',$attribute_cat['id'])->first();
						if(!isset($attribute['id'])){				
							$attribute=Attribute::create(['attribute' => rtrim($v,';'),'att_cat_id' => $attribute_cat['id']]);
						}
						$att_id=$attribute['id'];
						//check attribute-product relation exist or not
						$prod_attr=ProductAttribute::where('prod_id',$product_id)->where('attr_id',$att_id)->first();
						if(!isset($prod_attr['id'])){				
							$prod_attr=ProductAttribute::create(['prod_id' => $product_id,'attr_id' => $att_id]);
						}
						
						 //Add Variation Attributes
					   $variation_attr= VariationAttribute::create([
						   'variation_id' => $variation_id,
						   'product_attribute_id' => $prod_attr['id'],
					   ]);
					}
				}
				}
		  return $product;
		}
		
	 return null;
		  
   }
    public function headingRow(): int
    {
        return 1;
    }
}
