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

    public function all_products(Request $request)
    {
        // Get the selected category from the request
        $selected_category = $request->input('selected_category', 'all');
    
        // Start the query for products
        $query = Product::where('status', 1)->whereNull('deleted_at');
    
        // If the selected category is not 'all', filter by category
        if ($selected_category !== 'all') {
            $query->where('category_id', $selected_category);
        }
    
        // Paginate the results
        $products = $query->paginate(12); // Adjust the number per page as needed
    
        $products_data = [];
    
        foreach ($products as $product) {
            $category = Category::where('id', $product->category_id)->first();
    
            $products_data[] = [
                'id' => $product->id,
                'name' => $product->title,
                'category' => $category->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
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
    
            $products_data[] = [
                'id' => $product->id,
                'name' => $product->title,
                'category' => $category->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
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
