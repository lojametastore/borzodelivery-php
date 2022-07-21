<?php

namespace BorzoDelivery\Classes;


use BorzoDelivery\Utils\Str;
use BorzoDelivery\Utils\TypeFormatter;

abstract class ModelItemBase
{
    protected $attributeMap = [];

    protected $attributeValues = [];

    /**
     * @param array|\StdClass $data
     */
    public function __construct($data = null)
    {
        if ($data) {

            if (is_object($data))
                $data = (array)$data;

            foreach ($this->getAttributeMap() as $attribute => $attributeType) {
                if (isset($data[$attribute]) && $data[$attribute]) {
                    if (class_exists($attributeType) && $data[$attribute] instanceof $attributeType)
                        $this->attributeValues[$attribute] = $data[$attribute];
                    elseif (class_exists($attributeType) && get_parent_class($attributeType) == CollectionBase::class && !is_array($data[$attribute]))
                        $this->attributeValues[$attribute] = new $attributeType($data[$attribute]);
                    elseif (class_exists($attributeType) && get_parent_class($attributeType) == CollectionBase::class) {
                        $this->attributeValues[$attribute] = new $attributeType();
                        foreach ($data[$attribute] as $datum) {
                            $this->attributeValues[$attribute]->add($datum);
                        }
                    } else
                        $this->{$attribute} = TypeFormatter::cast($attributeType, $data[$attribute]);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getAttributeMap(): array
    {
        return $this->attributeMap;
    }

    public function getAttributeValues(): array
    {
        return $this->attributeValues;
    }

    public function __set($attribute, $value)
    {
        $attributeType = $this->attributeMap[$attribute] ?? null;

        if (class_exists($attributeType) && $value instanceof $attributeType)
            $this->attributeValues[$attribute] = $value;
        elseif (class_exists($attributeType))
            $this->attributeValues[$attribute] = new $attributeType($value);
        else
            $this->attributeValues[$attribute] = $value;
    }

    public function __get($attribute)
    {
        return $this->attributeValues[$attribute] ?? null;
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'get') === 0) {
            $attribute = ltrim($name, 'get');
            if (isset($this->attributeMap[Str::snake_case($attribute)]))
                return $this->{Str::snake_case($attribute)};
            else if (isset($this->attributeMap[\ucwords($attribute)]))
                return $this->{\ucwords($attribute)};
        }

        if (strpos($name, 'set') === 0) {
            $attribute = ltrim($name, 'set');
            $value = array_values($arguments);

            if (isset($this->attributeMap[Str::snake_case($attribute)]))
                $this->{Str::snake_case($attribute)} = array_shift($value);
            else if (isset($this->attributeMap[\ucwords($attribute)]))
                $this->{\ucwords($attribute)} = array_shift($value);
        }
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->getAttributeValues() as $attribute => $value) {
            if ($value instanceof CollectionBase || $value instanceof ModelItemBase)
                $array[$attribute] = $value->toArray();
            else
                $array[$attribute] = $value;
        }

        return $array;
    }

    public function toJson(): ?string
    {
        return json_encode($this->toArray());
    }
}