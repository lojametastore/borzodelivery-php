<?php

namespace Tests;

use BorzoDelivery\Api\Borzo;
use BorzoDelivery\Exceptions\ApiException;
use BorzoDelivery\Models\ContactPerson;
use BorzoDelivery\Requests\OrderRequest;
use BorzoDelivery\Requests\PackageRequest;
use BorzoDelivery\Requests\PackagesRequest;
use BorzoDelivery\Requests\PointsRequest;

class ExceptionTest extends TestCaseApi
{
    public function testException(): void
    {
        $packages = new PackagesRequest();

        for ($i = 1; $i <= 2; $i++) {
            $packages->add(new PackageRequest([
                'ware_code'           => $this->faker()->bothify('?????-#####'),
                'description'         => $this->faker()->text(),
                'items_count'         => $this->faker()->randomDigitNotNull(),
                'item_payment_amount' => $this->faker()->randomFloat(2, 10, 200),
            ]));
        }

        $contactPerson = new ContactPerson([
            'name'  => $this->faker()->name(),
            'phone' => $this->faker()->phoneNumber()
        ]);

        $points = new PointsRequest();

        $points->add([
            "address"         => '',
            "contact_person"  => $contactPerson,
            "client_order_id" => $this->faker()->randomDigit(),
            "note"            => $this->faker()->text(),
            "packages"        => $packages,
        ]);

        $points->add([
            "address"               => '',
            "contact_person"        => $contactPerson,
            "client_order_id"       => $this->faker()->randomDigit(),
            "note"                  => $this->faker()->text(),
            "is_order_payment_here" => $this->faker()->boolean(),
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
            "is_motobox_required"                    => $this->faker()->boolean(),
            "payment_method"                         => OrderRequest::PAYMENT_METHOD_NON_CASH,
            "points"                                 => $points,
        ]);

        try {

            $sdk = new Borzo($this->secret_auth_token, true);

            $response = $sdk->order()->priceCalculation($orderRequest);

        } catch (\Exception $apiException) {
            $this->assertInstanceOf(ApiException::class, $apiException);

            $warnings = $apiException->getWarnings();
            $this->assertIsArray($warnings);
            $this->assertCount(1, $warnings);
            $this->assertContains('invalid_parameters', $warnings);

            $parametersWarnings = $apiException->getparametersWarnings();
            $this->assertIsObject($parametersWarnings);
            $this->assertObjectHasAttribute('points', $parametersWarnings);
            $this->assertIsArray($parametersWarnings->points);
            $this->assertCount(2, $parametersWarnings->points);
        }
    }
}