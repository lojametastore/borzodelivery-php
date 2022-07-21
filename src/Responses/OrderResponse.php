<?php

namespace BorzoDelivery\Responses;

use BorzoDelivery\Classes\ModelItemBase;

class OrderResponse extends ModelItemBase
{
    protected $attributeMap = [
        'type'                                   => 'string',
        'order_id'                               => 'integer',
        'order_name'                             => 'string',
        'vehicle_type_id'                        => 'integer',
        'created_datetime'                       => 'timestamp',
        'finish_datetime'                        => 'timestamp',
        'status'                                 => 'string',
        'status_description'                     => 'string',
        'matter'                                 => 'string',
        'total_weight_kg'                        => 'integer',
        'is_client_notification_enabled'         => 'boolean',
        'is_contact_person_notification_enabled' => 'boolean',
        'loaders_count'                          => 'integer',
        'backpayment_details'                    => 'string',
        'points'                                 => PointsResponses::class,
        'payment_amount'                         => 'money',
        'delivery_fee_amount'                    => 'money',
        'weight_fee_amount'                      => 'money',
        'insurance_amount'                       => 'money',
        'insurance_fee_amount'                   => 'money',
        'loading_fee_amount'                     => 'money',
        'money_transfer_fee_amount'              => 'money',
        'suburban_delivery_fee_amount'           => 'money',
        'overnight_fee_amount'                   => 'money',
        'discount_amount'                        => 'money',
        'promo_code_discount_amount'             => 'money',
        'backpayment_amount'                     => 'money',
        'cod_fee_amount'                         => 'money',
        'backpayment_photo_url'                  => 'string',
        'itinerary_document_url'                 => 'string',
        'waybill_document_url'                   => 'string',
        'courier'                                => 'string',
        'is_motobox_required'                    => 'boolean',
        'payment_method'                         => 'string',
        'bank_card_id'                           => 'integer',
        'applied_promo_code'                     => 'string',
    ];
}