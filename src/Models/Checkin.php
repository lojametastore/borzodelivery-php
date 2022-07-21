<?php

namespace BorzoDelivery\Models;

use BorzoDelivery\Classes\ModelItemBase;

class Checkin extends ModelItemBase
{
    protected $attributeMap = [
        "recipient_full_name" => "string",
        "recipient_position"  => 'string'
    ];
}