<?php

namespace App\Traits;

use App\Cart\Core\CoreCart;

trait Cartable
{
    /**
     * Adds an item to the cart.
     *
     * @param int Identifier
     * @param int quantity
     * @return
     */
    public static function addToCart($id, $quantity = 1)
    {
        $class = static::class;

        return app(CoreCart::class)->add($class::findOrFail($id), $quantity);
    }
}
