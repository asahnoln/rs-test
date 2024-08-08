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
    $resp->assertJson(['data' =>
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

it('filters by all properties', function () {
    $color = Property::factory()->create(['name' => 'color']);
    $size = Property::factory()->create(['name' => 'size' ]);

    // These should stay
    $allProps = Product::factory(5)
        ->hasAttached($color, ['value' => 'black'])
        ->hasAttached($color, ['value' => 'white'])
        ->hasAttached($size, ['value' => 'large'])
        ->create();

    // These should be filtered out
    $partialProps = Product::factory(4)
        ->hasAttached($color, ['value' => 'white'])
        ->hasAttached($size, ['value' => 'large'])
        ->create();
    $partialProps2 = Product::factory(3)
        ->hasAttached($color, ['value' => 'black'])
        ->hasAttached($size, ['value' => 'small'])
        ->create();
    $noProps = Product::factory(2)->create();

    $resp = getJson('/products?properties[color][]=black&properties[color][]=white&properties[size][]=large');
    $resp->assertOk();

    $resp->assertJsonPath('data.0.name', $allProps[0]->name);
    $resp->assertJsonPath('data.2.name', $allProps[2]->name);
    $resp->assertJsonPath('data.4.name', $allProps[4]->name);
    $resp->assertJsonCount(5, 'data');
});

it('validation of properties', function () {
    $resp = getJson('/products?properties=false');
    $resp->assertUnprocessable();

    $resp = getJson('/products?properties[]=false');
    $resp->assertUnprocessable();

    $resp = getJson('/products?properties[][]=');
    $resp->assertUnprocessable();
});

it('product list paginated by 40', function () {
    Product::factory(100)->create();
    $resp = getJson('/products');
    $resp->assertOk();
    $resp->assertJsonCount(40, 'data');
});
