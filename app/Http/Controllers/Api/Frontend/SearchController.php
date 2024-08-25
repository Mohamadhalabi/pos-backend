<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Product\GetRequest;
use App\Services\SearchService;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    function products(GetRequest $request)
    {
        $search = new SearchService($request);
        if ($request->search != null && $request->disply_type == 'categories') {
            return response()->api_data($search->categoriesDisplay());
        }
        return response()->api_data($search->get());
    }

    function filter(GetRequest $request)
    {
        $search = new SearchService($request);

        return response()->api_data($search->filters());
    }

    function search_product(Request $request)
    {
        $searchTerm = $request->q;
        $products = Product::where('sku', 'like', '%' . $searchTerm . '%')
            ->orWhere('title', 'like', '%' . $searchTerm . '%')->take(8)->get();

        $products_data = [];

        foreach($products as $product)
        {
            $products_data[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->title,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => media_file($product->image),
                'description' => $product->description,
            ];
        }
        return response()->api_data(['products' => $products_data]);
        
    }
}
