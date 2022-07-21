<?php

namespace Tests;

use BorzoDelivery\Api\Borzo;
use BorzoDelivery\Models\ContactPerson;
use BorzoDelivery\Requests\OrderRequest;
use BorzoDelivery\Requests\PackageRequest;
use BorzoDelivery\Requests\PackagesRequest;
use BorzoDelivery\Requests\PointsRequest;
use BorzoDelivery\Responses\OrderResponse;

class OrderTest extends TestCaseApi
{
    protected $address1 = 'Rua Doutor Soares Brandão Filho, 123 - Vila Basileia, São Paulo - SP, Brasil';

    protected $address2 = 'Avenida Presidente Wilson, 222 - Vila Independencia, São Paulo - SP, Brasil';

    public function testRandomPriceCalculation(): void
    {
        $packages = new PackagesRequest();

        for ($i = 1; $i <= 2; $i++) {
            $packages->add(new PackageRequest([
                'ware_code'           => $this->faker()->bothify('?????-#####'),
                'description'         => $this->faker()->text(),
                'items_count'         => $this->faker()->randomDigitNotNull(),
                'item_payment_amount' => $this->faker()->randomFloat(2, 10, 200),
//                'nomenclature_code'   => $this->faker()->bothify('?????-#####')
            ]));
        }

        $contactPerson = new ContactPerson([
            'name'  => $this->faker()->name(),
            'phone' => $this->faker()->phoneNumber()
        ]);

        $points = new PointsRequest();

        $points->add([
            "address"         => $this->address1,
            "contact_person"  => $contactPerson,
            "client_order_id" => $this->faker()->randomDigit(),
//            "latitude"              => $this->faker()->latitude(),
//            "longitude"             => $this->faker()->longitude(),
//            "required_start_datetime"                => 'timestamp',
//            "required_finish_datetime"               => 'timestamp',
//            "taking_amount"                          => 'money',
//            "buyout_amount"                          => 'money',
            "note"            => $this->faker()->text(),
//            "is_order_payment_here" => $this->faker()->boolean(),
//            "building_number"                        => 'string',
//            "entrance_number"                        => 'string',
//            "intercom_code"                          => 'string',
//            "floor_number"                           => 'string',
//            "apartment_number"                       => 'string',
//            "invisible_mile_navigation_instructions" => 'string',
//            "is_cod_cash_voucher_required"           => 'boolean',
//            "delivery_id"                            => 'integer',
            "packages"        => $packages,
        ]);

        $points->add([
            "address"               => $this->address2,
            "contact_person"        => $contactPerson,
            "client_order_id"       => $this->faker()->randomDigit(),
//            "latitude"              => $this->faker()->latitude(),
//            "longitude"             => $this->faker()->longitude(),
//            "required_start_datetime"                => 'timestamp',
//            "required_finish_datetime"               => 'timestamp',
//            "taking_amount"                          => 'money',
//            "buyout_amount"                          => 'money',
            "note"                  => $this->faker()->text(),
            "is_order_payment_here" => $this->faker()->boolean(),
//            "building_number"                        => 'string',
//            "entrance_number"                        => 'string',
//            "intercom_code"                          => 'string',
//            "floor_number"                           => 'string',
//            "apartment_number"                       => 'string',
//            "invisible_mile_navigation_instructions" => 'string',
//            "is_cod_cash_voucher_required"           => 'boolean',
//            "delivery_id"                            => 'integer',
            "packages"              => $packages,
        ]);

        $orderRequest = new OrderRequest([
            "type"                                   => OrderRequest::ORDER_TYPE_STANDARD,
            "matter"                                 => $this->faker()->text(),
            "vehicle_type_id"                        => OrderRequest::VEHICLE_TYPE_MOTORBIKE,
            "total_weight_kg"                        => 3,
            "insurance_amount"                       => $this->faker()->randomFloat(2, 10, 200),
            "is_client_notification_enabled"         => $this->faker()->boolean(),
            "is_contact_person_notification_enabled" => $this->faker()->boolean(),
            "is_route_optimizer_enabled"             => $this->faker()->boolean(),
            "loaders_count"                          => 0,
//            "backpayment_details"                    => 'string',
            "is_motobox_required"                    => $this->faker()->boolean(),
            "payment_method"                         => OrderRequest::PAYMENT_METHOD_NON_CASH,
//            "bank_card_id"                           => 'integer',
//            "promo_code"                             => 'string',
            "points"                                 => $points,
        ]);

        $this->assertInstanceOf(OrderRequest::class, $orderRequest);

        $sdk = new Borzo($this->secret_auth_token, true);

        $response = $sdk->order()->priceCalculation($orderRequest);

        $this->assertInstanceOf(OrderResponse::class, $response);
        $this->assertCount(2, $response->getPoints()->first()->getPackages()->toArray());
    }

    public function testFixedPriceCalculation(): void
    {
        $points = new PointsRequest();

        $points->add([
            "address"               => $this->address1,
            "contact_person"        => new ContactPerson([
                'name'  => 'Polly',
                'phone' => '5511900000001'
            ]),
            "is_order_payment_here" => true,
        ]);

        $points->add([
            "address"               => $this->address2,
            "contact_person"        => new ContactPerson([
                'name'  => 'Jem',
                'phone' => '5511900000001'
            ]),
            "client_order_id"       => $this->faker()->randomDigit(),
            "is_order_payment_here" => false,
        ]);

        $orderRequest = new OrderRequest([
            "type"             => OrderRequest::ORDER_TYPE_STANDARD,
            "matter"           => 'Buys',
            "vehicle_type_id"  => OrderRequest::VEHICLE_TYPE_MOTORBIKE,
            "total_weight_kg"  => 5,
            "insurance_amount" => 150,
            "points"           => $points,
        ]);

        $this->assertInstanceOf(OrderRequest::class, $orderRequest);

        $sdk = new Borzo($this->secret_auth_token, true);

        $orderResponse = $sdk->order()->priceCalculation($orderRequest);

        $points = $orderResponse->getPoints()->toArray();

        $this->assertInstanceOf(OrderResponse::class, $orderResponse);
        $this->assertCount(2, $points);
    }
}