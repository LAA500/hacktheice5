<?php

namespace App\Services;

use JsonSerializable;

class Money implements JsonSerializable
{
    private $amount;
    private $currency;

    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function inDefaultCurrency($amount)
    {
        return new self($amount, 'RUB');
    }

    public function add($addend)
    {
        $addend = $this->convertToSameCurrency($addend);

        return $this->newInstance($this->amount + $addend->amount);
    }

    public function subtract($subtrahend = 0)
    {
        return $this->newInstance($this->amount - $subtrahend);
    }

    private function convertToSameCurrency($other)
    {
        if ($this->isNotSameCurrency($other)) {
            $other = $other->convertToDefaultCurrency();
        }

        $this->assertSameCurrency($other);

        return $other;
    }

    public function isZero()
    {
        return $this->amount == 0;
    }

    public function convertToCurrentCurrency($currencyRate = null)
    {
        return $this->convert($this->currency, $currencyRate);
    }

    public function convert($currency, $currencyRate = null)
    {
        $currencyRate = $currencyRate ?: 1;

        if (is_null($currencyRate)) {
            //throw new InvalidArgumentException("Cannot convert the money to currency [$currency].");
        }

        return new self($this->amount * $currencyRate, $currency);
    }

    public function isSameCurrency($other)
    {
        return $this->currency === $other->currency;
    }

    public function isNotSameCurrency($other)
    {
        return !$this->isSameCurrency($other);
    }

    private function assertSameCurrency($other)
    {
        if ($this->isNotSameCurrency($other)) {
            //throw new InvalidArgumentException('Mismatch money currency.');
        }
    }

    public function divide($divisor)
    {
        return $this->newInstance($this->amount / $divisor);
    }

    public function lessThan($other)
    {
        return $this->amount < $other->amount;
    }

    public function lessThanOrEqual($other)
    {
        return $this->amount <= $other->amount;
    }

    public function greaterThan($other)
    {
        return $this->amount > $other->amount;
    }

    public function greaterThanOrEqual($other)
    {
        return $this->amount >= $other->amount;
    }

    public function multiply($multiplier)
    {
        return $this->newInstance($this->amount * $multiplier);
    }

    private function newInstance($amount)
    {
        return new self($amount, $this->currency);
    }

    public function amount()
    {
        return $this->amount;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function format()
    {
        return price($this->amount, 0);
    }

    public function toArray()
    {
        return [
            'amount' => $this->amount,
            'formatted' => $this->format(),
            'currency' => $this->currency,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return (string) $this->amount;
    }
}
