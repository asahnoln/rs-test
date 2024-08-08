<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        $result = [];
        // TODO: Validation
        $props = $request->input('properties');
        if (!$props) {
            $result = Product::paginate(40);
            return $result;
        }

        $products = Product::select('products.*')
            ->join(
                'product_property',
                'products.id',
                '=',
                'product_property.product_id'
            )
            ->join(
                'properties',
                'product_property.property_id',
                '=',
                'properties.id'
            );
        foreach ($props as $key => $values) {
            $products->orWhere('properties.name', '=', $key)
            ->whereIn('product_property.value', $values);
        }

        return $products->paginate(40);
    }
}
