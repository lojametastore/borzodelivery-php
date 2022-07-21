<?php

namespace BorzoDelivery\Models;

use BorzoDelivery\Classes\ModelItemBase;

class ContactPerson extends ModelItemBase
{
    protected $attributeMap = [
        'name'  => 'string',
        'phone' => 'phone',
    ];
}