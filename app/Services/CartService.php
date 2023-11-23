<?php

namespace App\Services;

use App\Cart\Cart;
use App\Models\Coupon;
use App\Models\Product;
use JsonSerializable;

class CartService extends Cart implements JsonSerializable
{
    public function instance()
    {
        return $this;
    }

    public function saveCart($cart)
    {
        parent::save($cart);
    }

    public function clearCart()
    {
        $this->clear();

        $this->clearCartConditions();
    }

    public function store($uuid, int $qty = 1)
    {
        $product = Product::query()->where('uuid', $uuid)->first();

        return $this->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $qty,
            'associatedModel' => Product::class,
        ]);
    }

    public function remove($productId)
    {
        parent::remove($productId);

        return $this;
    }

    public function updateQuantity($id, $type)
    {
        match ($type) {
            'plus' => $this->incrementCartItem($id),
            'minus' => $this->decrementCartItem($id),
        };

        return $this;
    }

    public function incrementCartItem($id)
    {
        $this->update($id, [
            'quantity' => +1,
        ]);
    }

    public function decrementCartItem($id)
    {
        $this->update($id, [
            'quantity' => -1,
        ]);
    }

    public function reduceStock()
    {
        $this->manageStock(function ($cartItem) {
            $product = Product::find($cartItem->id);
            //$product->decrement('qty', $cartItem->qty);
            $product->increment('booked', $cartItem->qty);
        });
    }

    public function restoreStock()
    {
        $this->manageStock(function ($cartItem) {
            $product = Product::find($cartItem->id);
            $product->increment('qty', $cartItem->qty);
        });
    }

    private function manageStock($callback)
    {
        $this->items()->filter(function ($cartItem) {
            $product = Product::find($cartItem->id);
            return $product->manage_stock;
        })->each($callback);
    }

    public function products()
    {
        return $this->items()->map(function ($item) {
            return $item->product;
        });
    }

    public function removeCouponCart()
    {
        $this->removeConditionsByType('coupon');
        $this->clearCartItemConditions();
    }

    public function clearCartItemConditions()
    {
        $this->items()->each(function ($item) {
            $this->clearItemConditions($item->id);
        });
    }

    public function hasCoupon()
    {
        if ($this->getConditionsByType('coupon')->isEmpty()) {
            return false;
        }

        $couponId = $this->getConditionsByType('coupon')->first()->getAttribute('coupon_id');

        return Coupon::where('id', $couponId)->exists();
    }

    public function coupon()
    {
        if (!$this->hasCoupon()) {
            return new NullCartCoupon;
        }

        $couponCondition = $this->getConditionsByType('coupon')->first();
        $coupon = Coupon::with('products', 'categories')->find($couponCondition->getAttribute('coupon_id'));

        return new CartCoupon($this, $coupon, $couponCondition);
    }

    public function applyCoupon(Coupon $coupon)
    {
        $this->removeCouponCart();

        $this->condition(new CartCondition([
            'name' => $coupon->code,
            'type' => 'coupon',
            'target' => 'total',
            'value' => 0,
            'order' => 2,
            'attributes' => [
                'name' => $coupon->code,
                'coupon_id' => $coupon->id,
            ],
        ]));

        return $this->coupon();
    }

    public function couponAlreadyApplied(Coupon $coupon)
    {
        return $this->coupon()->code() == $coupon->code;
    }

    public function refreshPrice($refresh)
    {
        if ($refresh) {
            return $this->items->transform(function ($item) {
                $price = $item->price;
                $this->update($item->id, ['price' => $price]);

                return $item;
            });
        }

        return $this->items;
    }

    public function items($refresh = true)
    {
        return $this->refreshPrice($refresh)->map(function ($item) {
            return new CartItem($item);
        });
    }

    public function addedQty($productId)
    {
        return $this->findByProductId($productId)->sum('qty');
    }

    public function findByProductId($productId)
    {
        return $this->items()->filter(function ($cartItem) use ($productId) {
            return $cartItem->product->id == $productId;
        });
    }

    public function discount()
    {
        return $this->coupon()->value();
    }

    public function quantity()
    {
        return $this->getTotalQuantity();
    }

    public function total()
    {
        return $this->subTotal();
    }

    public function subTotal()
    {
        return Money::inDefaultCurrency($this->getSubTotal());
    }

    public function auth(): bool
    {
        return auth()->check();
    }

    public function cartIsEmpty(): bool
    {
        return $this->isEmpty();
    }

    public function toArray()
    {
        try {
            return [
                'success' => true,
                'coupon' => $this->coupon(),
                'items' => $this->items(),
                'quantity' => $this->quantity(),
                'empty' => $this->cartIsEmpty(),
                'auth' => $this->auth(),
                'subtotal' => $this->subTotal(),
                'total' => $this->total(),
            ];
        } catch (\Exception $e) {
            //self::clearCart();
            return [
                'success' => false,
                'message' => 'Произошла ошибка: ' . $e->getMessage(),
            ];
        }
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_UNESCAPED_UNICODE);
    }
}
