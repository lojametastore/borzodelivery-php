<?php

namespace BorzoDelivery\Responses;

use BorzoDelivery\Classes\ModelItemBase;
use BorzoDelivery\Models\Checkin;
use BorzoDelivery\Models\ContactPerson;

class PointResponse extends ModelItemBase
{
    protected $attributeMap = [
        'point_id'                               => 'integer',
        'delivery_id'                            => 'integer',
        'client_order_id'                        => 'integer',
        'address'                                => 'string',
        'latitude'                               => 'coordinate',
        'longitude'                              => 'coordinate',
        'required_start_datetime'                => 'timestamp',
        'required_finish_datetime'               => 'timestamp',
        'arrival_start_datetime'                 => 'timestamp',
        'arrival_finish_datetime'                => 'timestamp',
        'estimated_arrival_datetime'             => 'timestamp',
        'courier_visit_datetime'                 => 'timestamp',
        'contact_person'                         => ContactPerson::class,
        'taking_amount'                          => 'money',
        'buyout_amount'                          => 'money',
        'note'                                   => 'string',
        'packages'                               => PackagesResponses::class,
        'is_cod_cash_voucher_required'           => 'boolean',
        'is_order_payment_here'                  => 'boolean',
        'building_number'                        => 'string',
        'entrance_number'                        => 'string',
        'intercom_code'                          => 'string',
        'floor_number'                           => 'string',
        'apartment_number'                       => 'string',
        'invisible_mile_navigation_instructions' => 'string',
        'place_photo_url'                        => 'string',
        'sign_photo_url'                         => 'string',
        'checkin'                                => Checkin::class,
        'tracking_url'                           => 'string'
    ];
}