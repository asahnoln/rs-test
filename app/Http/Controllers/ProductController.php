<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public const PRODUCTS_PER_PAGE = 40;

    public function list(Request $request)
    {
        $data = $request->validate([
            'properties' => ['array'],
            'properties.*' => ['array'],
            'properties.*.*' => ['string'],
        ]);

        $props = $data['properties'] ?? null;

        if (!$props) {
            return Product::paginate(self::PRODUCTS_PER_PAGE);
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

        return $products->paginate(self::PRODUCTS_PER_PAGE);
    }
}
