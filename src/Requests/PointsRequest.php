<?php


namespace BorzoDelivery\Requests;

use BorzoDelivery\Classes\CollectionBase;

class PointsRequest extends CollectionBase
{
    protected $itemClassName = PointRequest::class;
}