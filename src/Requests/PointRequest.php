<?php

namespace BorzoDelivery\Requests;

use BorzoDelivery\Classes\ModelItemBase;
use BorzoDelivery\Models\ContactPerson;

class PointRequest extends ModelItemBase
{
    protected $attributeMap = [
        'address'                                => 'string',
        'contact_person'                         => ContactPerson::class,
        'client_order_id'                        => 'string',
        'latitude'                               => 'coordinate',
        'longitude'                              => 'coordinate',
        'required_start_datetime'                => 'timestamp',
        'required_finish_datetime'               => 'timestamp',
        'taking_amount'                          => 'money',
        'buyout_amount'                          => 'money',
        'note'                                   => 'string',
        'is_order_payment_here'                  => 'boolean',
        'building_number'                        => 'string',
        'entrance_number'                        => 'string',
        'intercom_code'                          => 'string',
        'floor_number'                           => 'string',
        'apartment_number'                       => 'string',
        'invisible_mile_navigation_instructions' => 'string',
        'is_cod_cash_voucher_required'           => 'boolean',
        'delivery_id'                            => 'integer',
        'packages'                               => PackagesRequest::class,
    ];
}