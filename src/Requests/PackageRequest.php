<?php

namespace BorzoDelivery\Requests;

use BorzoDelivery\Classes\ModelItemBase;

class PackageRequest extends ModelItemBase
{
    protected $attributeMap = [
        'ware_code'           => 'string',
        'description'         => 'string',
        'items_count'         => 'float',
        'item_payment_amount' => 'string',
        'nomenclature_code'   => 'string',
    ];
}