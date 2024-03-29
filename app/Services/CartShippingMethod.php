<?php

namespace App\Services;

use JsonSerializable;

class CartShippingMethod implements JsonSerializable
{
    private $cart;
    private $shippingMethodCondition;

    public function __construct($cart, $shippingMethodCondition)
    {
        $this->cart = $cart;
        $this->shippingMethodCondition = $shippingMethodCondition;
    }

    public function name()
    {
        return $this->shippingMethodCondition->getAttribute('shipping_method')['name'];
    }

    public function label()
    {
        return $this->shippingMethodCondition->getAttribute('shipping_method')->label;
    }

    public function cost()
    {
        return Money::inDefaultCurrency($this->calculate());
    }

    private function calculate()
    {
        return $this->shippingMethodCondition->getCalculatedValue($this->cart->subTotal()->amount());
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
