<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Attribute;
use App\Models\SubAttribute;

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
                'products_count' => Product::where('status',1)->whereNull('deleted_at')->where('category_id',$category->id)->count(),
            ];
        }
        return response()->api_data($categories_data);
    }

    public function all_products(Request $request)
    {
        $search = $request->input('search');

        // Get the selected category from the request
        $selected_category = $request->input('selected_category', 'all');
    
        // Start the query for products
        $query = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.status', 1)
        ->where('categories.status', 1)
        ->whereNull('products.deleted_at')
        ->select('products.*'); // Adjust the selected fields as needed
        
        // If the selected category is not 'all', filter by category
        if ($selected_category !== 'all') {
            $query->where('category_id', $selected_category);
        }

        if($search != ""){
            $query->where('sku',$search);
        }
        // Paginate the results
        $products = $query->paginate(12); // Adjust the number per page as needed

        $products_data = [];

        $products_attribute = [];

        $attribute_data = [];
    
        foreach ($products as $product) {
            
            if(json_decode($product->gallery,true) == [])
            $gallery = [media_file($product->image)];
            
            
            foreach (json_decode($product->gallery, true) ?? [] as $image)
            {
                $gallery[] = media_file($image);
            }
            
            $category = Category::where('id', $product->category_id)->first();


            $products_attribute = ProductsAttribute::where('product_id',$product->id)->pluck('sub_attribute_id')->toArray();
            
            $sub_attributes = SubAttribute::whereIn('id',$products_attribute)->get();

            foreach($sub_attributes as $sub_attribute)
            {
                $attrib = Attribute::where('id',$sub_attribute->attribute_id)->first();
                $attribute_data [] = [
                    'sub_attribute' => $sub_attribute->value,
                    'attribute' => $attrib->name,
                ];
            }
    
            $products_data[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->title,
                'category' => $category->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
                'gallery' => $gallery,
                'attributes' => $attribute_data,
                'description' => $product->description,
            ];
        }
    
        return response()->api_data([
            'products' => $products_data,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]
        ]);
    }
    
    public function products_by_category(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        $query = Product::where('status', 1)->whereNull('deleted_at');
    
        if ($categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }
    
        $products = $query->paginate(1);
    
        $products_data = [];
    
        foreach ($products as $product) {
            $category = Category::where('id', $product->category_id)->first();

            if(json_decode($product->gallery,true) == [])
            $gallery = [media_file($product->image)];
            
            
            foreach (json_decode($product->gallery, true) ?? [] as $image)
            {
                $gallery[] = media_file($image);
            }
            
            $category = Category::where('id', $product->category_id)->first();


            $products_attribute = ProductsAttribute::where('product_id',$product->id)->pluck('sub_attribute_id')->toArray();
            
            $sub_attributes = SubAttribute::whereIn('id',$products_attribute)->get();

            foreach($sub_attributes as $sub_attribute)
            {
                $attrib = Attribute::where('id',$sub_attribute->attribute_id)->first();
                $attribute_data [] = [
                    'sub_attribute' => $sub_attribute->value,
                    'attribute' => $attrib->name,
                ];
            }
    
            $products_data[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->title,
                'category' => $category->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
                'gallery' => $gallery,
                'attributes' => $attribute_data,
                'description' => $product->description,
            ];
        }
    
        return response()->api_data([
            'products' => $products_data,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]
        ]);
    }
}
