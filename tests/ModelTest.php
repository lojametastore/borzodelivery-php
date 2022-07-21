<?php

namespace Tests;

use BorzoDelivery\Classes\CollectionBase;
use BorzoDelivery\Classes\ModelItemBase;
use BorzoDelivery\Models\ContactPerson;
use BorzoDelivery\Requests\OrderRequest;
use BorzoDelivery\Requests\PackageRequest;
use BorzoDelivery\Requests\PackagesRequest;
use BorzoDelivery\Requests\PointsRequest;

class ModelTest extends TestCaseApi
{
    public function testRequestModels(): void
    {
        $packages = new PackagesRequest();

        $ware_code = $this->faker()->bothify('?????-#####');

        for ($i = 1; $i <= 2; $i++) {
            $packages->add(new PackageRequest([
                'ware_code'           => $ware_code,
                'description'         => $this->faker()->text(),
                'items_count'         => $this->faker()->randomNumber(),
                'item_payment_amount' => $this->faker()->randomFloat(2, 10, 200),
                'nomenclature_code'   => $this->faker()->bothify('?????-#####')
            ]));
        }

        $this->assertInstanceOf(ModelItemBase::class, $packages->first());
        $this->assertInstanceOf(PackageRequest::class, $packages->first());
        $this->assertEquals($ware_code, $packages->first()->ware_code);
        $this->assertEquals($ware_code, $packages->first()->getWareCode());

        $this->assertCount(2, $packages->toArray());
        $this->assertInstanceOf(CollectionBase::class, $packages);
        $this->assertInstanceOf(PackagesRequest::class, $packages);

        $name = $this->faker()->name();
        $phone = $this->faker()->phoneNumber();

        $contactPerson = new ContactPerson([
            'name'  => $name,
            'phone' => $phone
        ]);

        $this->assertEquals($name, $contactPerson->name);
        $this->assertEquals($name, $contactPerson->getName());
        $this->assertEquals($phone, $contactPerson->phone);
        $this->assertEquals($phone, $contactPerson->getPhone());

        $this->assertCount(2, $contactPerson->toArray());
        $this->assertInstanceOf(ContactPerson::class, $contactPerson);
        $this->assertInstanceOf(ModelItemBase::class, $contactPerson);

        $points = new PointsRequest();

        $points->add([
            "address"               => $this->faker()->address(),
            "contact_person"        => $contactPerson,
            "client_order_id"       => $this->faker()->randomDigit(),
            "latitude"              => $this->faker()->latitude(),
            "longitude"             => $this->faker()->longitude(),
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

        $points->add([
            "address"               => $this->faker()->address(),
            "contact_person"        => $contactPerson,
            "client_order_id"       => $this->faker()->randomDigit(),
            "latitude"              => $this->faker()->latitude(),
            "longitude"             => $this->faker()->longitude(),
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

        $this->assertInstanceOf(PointsRequest::class, $points);
        $this->assertInstanceOf(CollectionBase::class, $points);
        $this->assertCount(2, $points->first()->getPackages()->toArray());

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

        $this->assertInstanceOf(ModelItemBase::class, $orderRequest);
        $this->assertInstanceOf(OrderRequest::class, $orderRequest);

        $orderArray = $orderRequest->toArray();
        $this->assertIsArray($orderArray);
    }
}