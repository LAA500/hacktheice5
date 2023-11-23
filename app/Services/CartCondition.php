<?php

namespace App\Services;

use App\Cart\CartCondition as AppCartCondition;

class CartCondition extends AppCartCondition
{
    public function getAttribute($key, $default = null)
    {
        return array_get($this->getAttributes(), $key, $default);
    }
}
