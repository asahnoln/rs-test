<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function list(Request $request): LengthAwarePaginator
    {
        $data = $request->validate([
            'properties' => ['array'],
            'properties.*' => ['array'],
            'properties.*.*' => ['string'],
        ]);

        $props = $data['properties'] ?? null;

        if (!$props) {
            return Product::paginate();
        }

        $products = Product::select('products.*');

        $i = 0;
        foreach ($props as $name => $values) {
            foreach ($values as $value) {
                $i++;
                $products->join("properties as prop{$i}", "pp{$i}.property_id", '=', "prop{$i}.id");
                $products->where("prop{$i}.name", $name);
                $products->join("product_property as pp{$i}", 'products.id', '=', "pp{$i}.product_id");
                $products->where("pp{$i}.value", $value);
            }
        }

        return $products->paginate();
    }
}
