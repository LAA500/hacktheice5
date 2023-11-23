<?php

namespace App\Services;

use App\Models\Product;
use JsonSerializable;

class CartItem implements JsonSerializable
{
    public $id;
    public $name;
    public $qty;
    public $product;
    public $is_rent;

    public $hasDiscount;
    public $price;
    public $total;
    public $priceSum;
    public $discount;
    public $conditions;

    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->qty = $item->quantity;

        $this->price = $item->price;
        $this->hasDiscount = $item->hasConditions();
        $this->total = $item->getPriceSumWithConditions();
        $this->discount = $item->getPriceWithConditions();
        $this->priceSum = $item->getPriceSum();
        $this->conditions = $item->getConditions();

        $this->product = $item->model;
    }

    public function price()
    {
        return $this->price;
    }

    public function deposit()
    {
        return $this->product->deposit ?: 0;
    }

    public function unit()
    {
        return $this->product->unit;
    }

    public function unitFormat()
    {
        return array_get(Product::UNITS, $this->unit());
    }

    public function getPriceWithDiscount()
    {
        $discount = Money::inDefaultCurrency($this->unitPrice())->subtract($this->discount)->amount();
        return Money::inDefaultCurrency($this->unitPrice())->subtract($discount)->amount();
    }

    public function total()
    {
        return Money::inDefaultCurrency($this->total);
    }

    public function product()
    {
        return $this->product->only([
            'id',
            'name',
            'price',
            'image',
            'selling_price',
            'qty',
            'link',
            'uuid',
        ]);
    }

    public function unitPrice()
    {
        return $this->price;
    }

    /**
     * 
     * 
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'product' => $this->product(),
            'unitPrice' => Money::inDefaultCurrency($this->unitPrice()),
            'unit' => $this->unitFormat(),
            'price_with_discount' => $this->getPriceWithDiscount(),
            'total' => $this->total(),
            'hasDiscount' => $this->hasDiscount,
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
