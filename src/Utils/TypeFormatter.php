<?php

namespace BorzoDelivery\Utils;


class TypeFormatter
{
    public static function cast($type, $value = null)
    {
        if (null === $value)
            return $value;

        switch ($type) {
            case 'string':
            case 'phone':
            {
                return (string)$value;
            }
            case 'integer':
            {
                return intval($value);
            }
            case 'float':
            case 'coordinate':
            case 'money':
            case 'decimal':
            {
                return floatval($value);
            }
            case 'boolean':
            {
                return boolval($value);
            }
            default:
            {
                if (class_exists($type))
                    return new $type($value);
            }
        }

        return $value;
    }
}