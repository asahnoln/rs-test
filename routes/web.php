<?php

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// TODO: Controller
Route::get('/products', function () {
    $result = [];
    // TODO: Validation
    $props = request()->input('properties');
    if (!$props) {
        $result = Product::all();
    } else {
        // TODO: Optimize (all props and their values at once)
        foreach (request()->input('properties', []) as $key => $value) {
            $products = Product::select('products.*')
                ->join('product_property', 'products.id', '=', 'product_property.product_id')
                ->join('properties', 'product_property.property_id', '=', 'properties.id')
                ->where('properties.name', '=', $key)
                ->where('product_property.value', '=', $value)
                ->get();
            $result = [...$result, ...$products];
        }
    }
    return [
        'data' => $result,
    ];
});
