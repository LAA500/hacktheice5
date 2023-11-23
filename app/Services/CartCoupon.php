<?php

namespace App\Services;

use JsonSerializable;

class CartCoupon implements JsonSerializable
{
    public $cart;
    public $coupon;
    public $couponCondition;

    public function __construct($cart, $coupon, $couponCondition)
    {
        $this->cart = $cart;
        $this->coupon = $coupon;
        $this->couponCondition = $couponCondition;

        $this->store();
    }

    public function entity()
    {
        return $this->coupon;
    }

    public function id()
    {
        return $this->coupon->id;
    }

    public function code()
    {
        return $this->coupon->code;
    }

    public function store()
    {
        $count = $this->getCouponValue();
        $this->couponApplicableProducts()->map(function ($item) use ($count) {
            $this->cart->clearItemConditions($item->id);
            $this->cart->addItemCondition($item->id, new CartCondition([
                'name' => $this->coupon->code,
                'type' => 'coupon',
                'value' => $count,
            ]));
        });
    }

    public function getCouponValue()
    {
        if ($this->coupon->is_percent) {
            return "-{$this->coupon->value}%";
        }

        $amount = $this->countProducts() ? $this->coupon->value->amount() / $this->countProducts() : 0;
        return "-{$amount}";
    }

    public function countProducts()
    {
        return $this->couponApplicableProducts()->sum(function ($item) {
            return $item->qty;
        });
    }

    public function isFreeShipping()
    {
        return $this->coupon->free_shipping;
    }

    public function usageLimitReached($customerEmail)
    {
        return $this->fresh()->coupon->usageLimitReached($customerEmail);
    }

    public function didNotSpendTheRequiredAmount()
    {
        return $this->fresh()->coupon->didNotSpendTheRequiredAmount();
    }

    public function spentMoreThanMaximumAmount()
    {
        return $this->fresh()->coupon->spentMoreThanMaximumAmount();
    }

    public function fresh()
    {
        $this->coupon = $this->coupon->refresh();

        return $this;
    }

    public function usedOnce()
    {
        $this->coupon->increment('used');
    }

    public function value()
    {
        if ($this->coupon->free_shipping) {
            return $this->cart->shippingMethod()->cost();
        }

        return Money::inDefaultCurrency($this->conditions());
    }

    private function calculate()
    {
        return $this->couponCondition->getCalculatedValue($this->productsTotalPrice());
    }

    private function productsTotalPrice()
    {
        return $this->couponApplicableProducts()->sum(function ($cartItem) {
            return $cartItem->total();
        });
    }

    private function couponApplicableProducts()
    {
        return $this->cart->items()->filter(function ($cartItem) {
            return $this->inApplicableProducts($cartItem);
        })->reject(function ($cartItem) {
            return $this->inExcludedProducts($cartItem);
        })->filter(function ($cartItem) {
            return $this->inApplicableCategories($cartItem);
        })->reject(function ($cartItem) {
            return $this->inExcludedCategories($cartItem);
        });
    }

    private function inApplicableProducts($cartItem)
    {
        if ($this->coupon->products->isEmpty()) {
            return true;
        }

        return $this->coupon->products->contains($cartItem->product);
    }

    private function inExcludedProducts($cartItem)
    {
        if ($this->coupon->excludeProducts->isEmpty()) {
            return false;
        }

        return $this->coupon->excludeProducts->contains($cartItem->product);
    }

    private function inApplicableCategories($cartItem)
    {
        if ($this->coupon->categories->isEmpty()) {
            return true;
        }

        return $this->coupon->categories->intersect($cartItem->product->categories)->isNotEmpty();
    }

    private function inExcludedCategories($cartItem)
    {
        if ($this->coupon->excludeCategories->isEmpty()) {
            return false;
        }

        return $this->coupon->excludeCategories->intersect($cartItem->product->categories)->isNotEmpty();
    }

    public function conditions()
    {
        $array = [];
        foreach ($this->couponApplicableProducts() as $item) {
            if ($item->hasDiscount) {
                foreach ($item->conditions as $row) {
                    array_push($array, $row->parsedRawValue * $item->qty);
                }
            }
        }
        return array_sum($array) ?? 0;
    }

    public function toArray()
    {
        return [
            'code' => $this->code(),
            'value' => $this->value(),
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
