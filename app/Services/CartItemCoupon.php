<?php

namespace App\Services;

use JsonSerializable;

class CartItemCoupon implements JsonSerializable
{
    public $cart;
    public $coupon;
    public $item;
    public $value;

    public function __construct($cart, $coupon, $item, $value)
    {
        $this->cart = $cart;
        $this->coupon = $coupon;
        $this->item = $item;
        $this->value = $value;
    }

    public function store()
    {
        $this->cart->clearItemConditions($this->item->id);
        $this->cart->addItemCondition($this->item->id, new CartCondition([
            'name' => $this->coupon->code,
            'type' => 'coupon',
            'value' => $this->value,
        ]));

        return 'OK';
    }

    public function jsonSerialize()
    {
        return $this->store();
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
