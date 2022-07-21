# PHP Client to API [Borzo Delivery](https://borzodelivery.com)

### API Documentation:

https://borzodelivery.com/br/business-api/doc


### Requeriments:

* PHP >= 7.4


## Get started

- [Install](#Install)
- [Authentication](#Authentication)
- [Available Methods](#Available Methods)
    - [Order price calculation](#Order price calculation)
- [Executing the unit tests](#Executing the unit tests)
- [Exceptions](#Exceptions)


### Install

Using composer to install package:

`composer require lojametastore/borzodelivery-sdk-php`

### Authentication

See the example below about creating an instance with autentication:

```php
use BorzoDelivery\Api\Borzo;

$borzoSdk = new Borzo('SECRET_AUTH_TOKEN');
```


### Available Methods

#### Order price calculation

The calculation price method from the order is used to simulate the delivery price between one or more points.
All the available request parameters can be seen in https://borzodelivery.com/br/business-api/doc#calculate-order

```php
$points = new Points();

$points->add([
    "address"               => 'Address 1',
    "contact_person"        => new ContactPerson([
        'name'  => 'Jem',
        'phone' => '+1-202-555-0171'
    ]),
    "is_order_payment_here" => true,
]);

$points->add([
    "address"               =>'Address 2',
    "contact_person"        => new ContactPerson([
        'name'  => 'Polly',
        'phone' => '+1-202-555-0172'
    ]),
    "client_order_id"       => $this->faker()->randomDigit(),
    "is_order_payment_here" => false,
]);

$orderRequest = new Order([
    "type"             => Order::ORDER_TYPE_STANDARD,
    "matter"           => 'Buys',
    "vehicle_type_id"  => Order::VEHICLE_TYPE_MOTORBIKE,
    "total_weight_kg"  => 5,
    "insurance_amount" => 150,
    "points"           => $points,
]);

$borzoSdk->priceCalculation($order);
```

### Executing the unit tests

To execute the unit tests, before you need set an environment variable named `SECRET_AUTH_TOKEN`


### Exceptions

When a request returns any failure it will trigger an exception with the class `BorzoDelivery\Exceptions\ApiException`.
You can simply catch this exception with the below example:

```php
use BorzoDelivery\Exceptions\ApiException;

try{

    $borzoSdk->priceCalculation($order);

} catch (ApiException $apiException) {
    $errors = $apiException->getErrors();
    $warnings = $apiException->getWarnings();
    $parametersWarnings = $apiException->getparametersWarnings();
}
```