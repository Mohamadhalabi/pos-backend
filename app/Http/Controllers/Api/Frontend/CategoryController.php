<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('status',1)->whereNull('deleted_at')->get();
        $categories_data = [];
        foreach($categories as $category){
            $categories_data [] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => media_file($category->icon),
            ];
        }
        return response()->api_data($categories_data);
    }

    public function all_products()
    {
        $products = Product::where('status',1)->whereNull('deleted_at')->get();
        $products_data = [];

        foreach($products as $product){

            $category = Category::where('id',$product->category_id)->first();


            $products_data [] = [
                'id' => $product->id,
                'name' => $product->title,
                'category' => $category->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
            ];
        }

        return response()->api_data($products_data);
    }
}
