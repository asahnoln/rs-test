<?php

use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('has product list', function () {
    Product::factory()->create(['name' => 'Test name', 'price' => 100, 'quantity' => 2]);
    Product::factory()->create(['name' => 'Wow!', 'price' => 200, 'quantity' => 3]);

    $resp = getJson('/products');

    $resp->assertOk();
    $resp->assertExactJson(['data' =>
        [
            [
                'id' => 1,
                'name' => 'Test name',
                'price' => 100,
                'quantity' => 2,
            ],
            [
                'id' => 2,
                'name' => 'Wow!',
                'price' => 200,
                'quantity' => 3,
            ],
        ],
    ]);
});

it('filters by properties', function () {
    $color = Property::factory()->create(['name' => 'color' ]);
    $size = Property::factory()->create(['name' => 'size' ]);
    $blackProducts = Product::factory(1)->hasAttached($color, ['value' => 'black'])->create();
    $whiteProducts = Product::factory(2)->hasAttached($color, ['value' => 'white'])->create();
    $largeProducts = Product::factory(3)->hasAttached($size, ['value' => 'large'])->create();
    $smallProducts = Product::factory(4)->hasAttached($size, ['value' => 'small'])->create();

    $resp = getJson('/products?properties[color]=black&properties[size]=large');
    $resp->assertOk();

    $resp->assertJsonPath('data.0.name', $blackProducts[0]->name);
    $resp->assertJsonPath('data.2.name', $largeProducts[1]->name);
});
