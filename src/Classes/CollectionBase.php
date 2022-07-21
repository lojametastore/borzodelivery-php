<?php

namespace BorzoDelivery\Classes;


abstract class CollectionBase
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $itemClassName;

    public function __construct($data = null)
    {
        $this->add($data);
    }

    public function add($item): self
    {
        if ($item) {
            if ($item instanceof $this->itemClassName)
                $this->items[] = $item;
            elseif (is_array($item) || is_object($item))
                $this->add(new $this->itemClassName($item));
        }

        return $this;
    }

    public function first()
    {
        return reset($this->items);
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->items as $item) {
            if ($item instanceof ModelItemBase) {
                $result[] = $item->toArray();
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }
}