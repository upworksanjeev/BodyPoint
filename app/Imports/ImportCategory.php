<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\AttributeCategory;

class ImportCategory implements ToModel
{
   
   public function model(array $row)
   {
	  
	   if($row[2]!='Item_Name' && $row[2]!='' && isset($row[5])){
		    if($row[1]=='MODEL'){ $product_type="Single"; }else{ $product_type="Option"; }
			//check product exist or not
		   $product=Product::where('name',$row[2])->where('product_type',$product_type)->first();
		   if(isset($product['id'])){
				   $product_id=$product['id'];
			   }else{
				   //Add product
				   $product= Product::create([
					   'name' => $row[2],
						'product_type' => $product_type,
					   'is_deleted' => 0,
					   'overview' => $row[54]??'',
					   'sizing' => $row[55]??'',
					   'instruction_of_use' => $row[53]??'',
				   ]);
				    
				   $product_id=$product['id'];
			   }
		   $cat_arr=explode(',',$row[5]);
		   
		   if(count($cat_arr)>0){
		   //Add multiple category
		   foreach($cat_arr as $k=>$v){
			   //check category exist or not
				$cat=Category::where('name',$v)->first();
							
			   if(isset($cat['id'])){
				   $cat_id=$cat['id'];
			   }else{
				   
				   $cat= Category::create([
					   'name' => $v,
				   ]);
				    $cat_id=$cat['id'];
				  
			   }
			   //check Category-product relation exist or not
			   	$catprod=CategoryProduct::where('category_id',$cat_id)->where('product_id',$product_id)->first();		   
			   //Add category_product relation
			    if(!isset($catprod['id'])){
					$categoryproduct=CategoryProduct::create(['category_id' => $cat_id,'product_id' => $product_id]);
				}
			}
		   }
		  
		   
		   
		  
		  return $product;
		}else{
			/* Add attributes category*/
		   for($i=6;$i<52;$i++){
		   if(isset($row[$i])){
			   if(str_contains($row[$i],'Attributes/')){
				   //check Category-product relation exist or not
					$attribute_cat=AttributeCategory::where('category',str_replace('Attributes/','',$row[$i]))->first();
					if(!isset($catprod['id'])){				
						$attribute_cat=AttributeCategory::create(['category' => str_replace('Attributes/','',$row[$i])]);
					}
			   }
			}
		   }
		}
	
	 return null;
		  
   }
}
