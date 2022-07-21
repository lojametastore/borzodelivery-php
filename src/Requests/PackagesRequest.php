<?php


namespace BorzoDelivery\Requests;

use BorzoDelivery\Classes\CollectionBase;

class PackagesRequest extends CollectionBase
{
    protected $itemClassName = PackageRequest::class;
}