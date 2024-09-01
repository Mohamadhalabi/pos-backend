<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Frontend\Setting\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Slider;
use App\Models\Product;

class SettingController extends Controller
{
    public function get(SettingRequest $request)
    {

        $sliders_data = [];

        $acceptLanguage = request()->header('Accept-Language');

        $sliders = Slider::where('status', 1)
        ->where('ends_on', '>', now())
        ->get();
    
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.status', 1)
        ->where('categories.status', 1)
        ->whereNull('products.deleted_at')
        ->select('products.*') // Adjust the selected fields as needed
        ->count();

        foreach($sliders as $slider)
        {
            $sliders_data [] = [
                'image' => media_file($slider->image),
                'link' => $slider->link,
            ];
        }


        $website_settings = Setting::where('type','system_name')->first();

        $value = json_decode($website_settings->value,true);

        $system_name = $value; // Fallback to 'en' if the locale is not present


        $shipping_cost  = Setting::where('type','shipping_price')->first();
        $vat_cost = Setting::where('type','vat')->first();
        $longitude = Setting::where('type','longitude')->first();
        $latitude = Setting::where('type','latitude')->first();
        $free_shipping = Setting::where('type','free_shipping')->first();

        $website_setting = [
            'system_name' => $system_name
        ];



        $website_setting['system_logo_icon'] = media_file(get_setting('system_logo_icon'));
        $website_setting['system_logo_black'] = media_file(get_setting('system_logo_black'));
        $website_setting['default_images'] = media_file(get_setting('default_images'));
        $website_setting['system_logo_white'] = media_file(get_setting('system_logo_white'));


        $setting['website'] = $website_setting;

        return response()->data([
            'setting' => $setting ,
            'sliders' => $sliders_data,
            'products_count' => $products,
            'shipping_cost' => $shipping_cost->value,
            'vat_cost' => $vat_cost->value,
            'longitude' => $longitude->value,
            'latitude' => $latitude->value,
            'free_shipping' => $free_shipping->value,
        ]);
    }

}
