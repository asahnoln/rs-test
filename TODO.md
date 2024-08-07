# TODO

## Entities

- [ ] Product: name, price, quantity
- [ ] Product-to-property: Many-to-many: value
- [ ] Property: name

## Flow

- [ ] `GET /products?properties[свойство1][]=значение1*своства1&properties[свойство1][]=значение2*своства1&properties[свойство2][]=значение1_свойства2`
- [ ] Нужен api GET метод получения списка товаров (“каталог товаров”) пагинированных по 40

## View

| Lamp 1  | Lamp 2  | Table 1 | Table 2 | Chair  |
| ------- | ------- | ------- | ------- | ------ |
| Power   | Power   | Color   | Color   | Color  |
| Color   | Color   | Type2   | Type2   | Type3  |
| Type    | Type    | Madeof  | Madeof  | Madeof |
| Crochet | Crochet |         |         | Legs   |
