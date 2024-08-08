# Rocket Science Test Task

![tests](https://github.com/asahnoln/rs-test/workflows/tests/badge.svg)

Implemented according to the given task description.

## Endpoints

- Filters by any property (OR logic): `GET /products?properties[prop1][]=prop1_value1&properties[prop1][]=prop1_value2&properties[prop2][]=prop2_value1`
- Filters by all properties (AND logic): `GET /products?all=true&properties[prop1][]=prop1_value1&properties[prop1][]=prop1_value2&properties[prop2][]=prop2_value1`

## Tests

```fish
php artisan test
```

## Might be of interest

- ./tests/Feature/ProductTest.php
- ./app/Http/Controllers/ProductController.php
- ./app/Models/Product.php
- ./app/Models/Property.php
