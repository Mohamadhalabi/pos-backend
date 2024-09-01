<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Attribute;
use App\Models\SubAttribute;
use App\Models\ProductsPackages;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('status',1)->whereNull('deleted_at')->whereNull('parent_id')->get();
        $categories_data = [];
        foreach($categories as $category){
            $categories_data [] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => media_file($category->icon),
                'products_count' => Category::where('status',1)->whereNull('deleted_at')->where('parent_id',$category->id)->count(),
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
        ->whereNull('categories.deleted_at')
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
                'quantity' => $product->quantity,
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
    
    public function products_by_category($id, Request $request)
    {
        // The $id parameter from the route corresponds to the category ID
        // Use it directly instead of $request->input('category_id')
    
        // Check if the provided category ID is valid (optional)
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid category ID'], 400);
        }
    
        // Initialize the query for products
        $query = Product::where('status', 1)->whereNull('deleted_at');
    
        // Filter by category ID if it's not 'all'
        if ($id !== 'all') {
            $query->where('category_id', $id);
        }
    
        // Paginate the results
        $products = $query->paginate(12);
    
        $products_data = [];
    
        foreach ($products as $product) {
            $category = Category::where('id', $product->category_id)->first();
    
            // Handle the gallery images
            $gallery = json_decode($product->gallery, true) ?? [];
            if (empty($gallery)) {
                $gallery = [media_file($product->image)];
            } else {
                $gallery = array_map('media_file', $gallery);
                array_unshift($gallery, media_file($product->image)); // Include the main image as the first item
            }
    
            // Retrieve product attributes
            $products_attribute = ProductsPackages::where('product_id', $product->id)->get();

            $product_attrb = ProductsAttribute::where('product_id',$product->id)->pluck('sub_attribute_id');

            $sub_attributes_id = SubAttribute::whereIn('id',$product_attrb)->where('attribute_id',1)->first();

            
            $attribute_data = [];
            foreach ($products_attribute as $sub_attribute) {
                $attribute_data[] = [
                    'from' => $sub_attribute->from,
                    'to' => $sub_attribute->to,
                    'price' => $sub_attribute->price,
                    'unit' => $sub_attributes_id->value,
                ];
            }
    
            // Prepare the product data
            $products_data[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->title,
                'category' => $category ? $category->name : null,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
                'gallery' => $gallery,
                'attributes' => $attribute_data,
                'description' => $product->description,
                'quantity' => $product->quantity,
            ];
        }
    
        // Return the response with products and pagination
        return response()->json([
            'products' => $products_data,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ]);
    }
    

    public function get_sub_categories(Request $request)
    {
        $categories = Category::where('status', 1)
            ->whereNull('deleted_at')
            ->where('parent_id', $request->sub_category)
            ->get();
            
        $categories_data = [];
        $products_data = [];
    
        $products_query = Product::where('status', 1)
            ->whereNull('deleted_at')
            ->where('category_id', $request->sub_category);
    
        $data_product = $products_query->paginate(12);
    
        if ($data_product->isNotEmpty()) {
            foreach ($data_product as $product) {
                $cat = Category::where('id', $product->category_id)->first();
        
                // Handle the gallery images
                $gallery = json_decode($product->gallery, true) ?? [];
                if (empty($gallery)) {
                    $gallery = [media_file($product->image)];
                } else {
                    $gallery = array_map('media_file', $gallery);
                    array_unshift($gallery, media_file($product->image)); // Include the main image as the first item
                }
        
                // Retrieve product attributes
                $products_attribute = ProductsPackages::where('product_id', $product->id)->get();
                $product_attrb = ProductsAttribute::where('product_id', $product->id)->pluck('sub_attribute_id');
                $sub_attributes_id = SubAttribute::whereIn('id', $product_attrb)->where('attribute_id', 1)->first();
    
                // Check if $sub_attributes_id is not null
                $attribute_data = [];
                if ($sub_attributes_id) {
                    foreach ($products_attribute as $sub_attribute) {
                        $attribute_data[] = [
                            'from' => $sub_attribute->from,
                            'to' => $sub_attribute->to,
                            'price' => $sub_attribute->price,
                            'unit' => $sub_attributes_id->value,
                        ];
                    }
                }
        
                // Prepare the product data
                $products_data[] = [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->title,
                    'category' => $cat ? $cat->name : null,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => media_file($product->image),
                    'gallery' => $gallery,
                    'attributes' => $attribute_data,
                    'description' => $product->description,
                    'quantity' => $product->quantity,
                ];
            }
        }
    
        foreach ($categories as $category) {
            $categories_data[] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => media_file($category->icon),
                'products_count' => Product::where('status', 1)
                    ->whereNull('deleted_at')
                    ->where('category_id', $category->id)
                    ->count(),
            ];
        }
    
        return response()->json([
            'category_data' => $categories_data,
            'products' => $products_data,
            'pagination' => [
                'total' => $data_product->total(),
                'per_page' => $data_product->perPage(),
                'current_page' => $data_product->currentPage(),
                'last_page' => $data_product->lastPage(),
                'from' => $data_product->firstItem(),
                'to' => $data_product->lastItem(),
            ],
        ]);
    }    
}
