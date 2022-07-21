<?php

namespace BorzoDelivery\Requests;

use BorzoDelivery\Classes\ModelItemBase;

class OrderRequest extends ModelItemBase
{
    public const VEHICLE_TYPE_TRUCK = 5;
    public const VEHICLE_TYPE_PUBLIC_TRANSPORT = 6;
    public const VEHICLE_TYPE_CAR = 7;
    public const VEHICLE_TYPE_MOTORBIKE = 8;

    public const ORDER_TYPE_STANDARD = 'standard';
    public const ORDER_TYPE_SAME_DAY = 'same_day';

    public const PAYMENT_METHOD_CASH = 'cash';
    public const PAYMENT_METHOD_NON_CASH = 'non_cash';
    public const PAYMENT_METHOD_BANK_CARD = 'bank_card';

    protected $attributeMap = [
        'type'                                   => 'string',
        'matter'                                 => 'string',
        'vehicle_type_id'                        => 'integer',
        'total_weight_kg'                        => 'integer',
        'insurance_amount'                       => 'money',
        'is_client_notification_enabled'         => 'boolean',
        'is_contact_person_notification_enabled' => 'boolean',
        'is_route_optimizer_enabled'             => 'boolean',
        'backpayment_details'                    => 'string',
        'is_motobox_required'                    => 'boolean',
        'payment_method'                         => 'string',
        'bank_card_id'                           => 'integer',
        'promo_code'                             => 'string',
        'points'                                 => PointsRequest::class,
    ];
}