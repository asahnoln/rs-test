<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
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

        $products = Product::where(function (Builder $query) use ($props) {
            foreach ($props as $name => $values) {
                foreach ($values as $value) {
                    $query->whereHas('properties', function (Builder $query) use ($name, $value) {
                        $query->where('properties.name', $name)
                            ->where('product_property.value', $value);
                    });
                }
            }
        });

        return $products->paginate();
    }
}
