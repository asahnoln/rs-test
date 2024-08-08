# Rocket Science Test Task

![tests](https://github.com/asahnoln/rs-test/workflows/tests/badge.svg)

Implemented according to the given task description.

## Performance

Joins in test benchmark show results about 6.831061 ms. Eloquent alternatives as whereHas are 200 times slower.

## Endpoints

- `GET /products?properties[prop1][]=prop1_value1&properties[prop1][]=prop1_value2&properties[prop2][]=prop2_value1`

## Tests

```fish
php artisan test

# Run with benchmark
BENCHMARK=1 php artisan test
```

## Files to inspect

- [Product tests](./tests/Feature/ProductTest.php)
- [Controller](./app/Http/Controllers/ProductController.php)
