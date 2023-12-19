<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\AttributeCategory;
use App\Models\Attribute;
use App\Models\ProductAttribute;

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
					$catprod=CategoryProduct::create(['category_id' => $cat_id,'product_id' => $product_id]);
				}
			}
		   }
		   $j=1;
		   /* Add attributes of product */
		   for($i=6;$i<52;$i++){
		   if(isset($row[$i]) && $row[$i]!=''){
				   //check attribute exist or not
					$attribute=Attribute::where('attribute',rtrim($row[$i],';'))->where('att_cat_id',$j)->first();
					if(!isset($attribute['id'])){				
						$attribute=Attribute::create(['attribute' => rtrim($row[$i],';'),'att_cat_id' => $j]);
					}
					$att_id=$attribute['id'];
					//check attribute-product relation exist or not
					$prod_attr=ProductAttribute::where('prod_id',$product_id)->where('attr_id',$att_id)->first();
					if(!isset($prod_attr['id'])){				
						$prod_attr=ProductAttribute::create(['prod_id' => $product_id,'attr_id' => $att_id]);
					}
			}
			$j++;
		   }		  
		  return $product;
		}else{
			/* Add attributes category */
		   for($i=6;$i<52;$i++){
		   if(isset($row[$i])){
			   if(str_contains($row[$i],'Attributes/')){
				   //check attribute category  exist or not
					$attribute_cat=AttributeCategory::where('category',str_replace('Attributes/','',$row[$i]))->first();
					if(!isset($attribute_cat['id'])){				
						$attribute_cat=AttributeCategory::create(['category' => str_replace('Attributes/','',$row[$i])]);
					}
			   }
			}
		   }
		}
	
	 return null;
		  
   }
}
