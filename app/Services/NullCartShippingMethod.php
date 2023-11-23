<?php

namespace App\Services;

use JsonSerializable;

class NullCartShippingMethod implements JsonSerializable
{
    public function name()
    {
        return 'pickup';
    }

    public function label()
    {
        return 'Самовывоз';
    }

    public function cost()
    {
        return Money::inDefaultCurrency(0);
    }

    public function toArray()
    {
        return [
            'name' => $this->name(),
            'cost' => $this->cost(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
