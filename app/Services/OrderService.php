<?php

namespace App\Services;

use App\Facades\Cart;
use App\Models\Order;

class OrderService
{

    public function create(array $data)
    {
        return tap($this->store($data), function ($order) use ($data) {
            $this->storeOrderProducts($order);
            $this->putSessionOrder($order);
            $this->incrementCouponUsage();
            //$this->reduceStock();
            $this->clearCart();
        });
    }

    public function store(array $data)
    {
        $cart = Cart::class;

        $order = Order::query()->create([
            'user_id' => auth()->id(),
            'shop_id' => session('city.id'),
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'payment_method' => array_get($data, 'payment_method'),
            'delivery_method' => array_get($data, 'delivery_method'),
            'total' => $cart::total()->amount(),
            'subtotal' => $cart::subTotal()->amount(),
            'discount' => 0,
            'address' => array_get($data, 'address'),
            'delivery_cost' => array_get($data, 'delivery_cost') ?: 0,
            'status' => 1,
        ]);

        return $order;
    }

    private function storeOrderProducts(Order $order)
    {
        Cart::items()->each(function (\App\Services\CartItem $item) use ($order) {
            $order->products()->attach($item->id, ['price' => $item->price(), 'quantity' => $item->qty, 'total' => $item->total ?? 0]);
        });
    }

    private function putSessionOrder($order)
    {
        session()->put('placed_order', $order);
    }

    private function incrementCouponUsage()
    {
        Cart::coupon()->usedOnce();
    }

    private function clearCart()
    {
        Cart::clear();
    }

    public function reduceStock()
    {
        Cart::reduceStock();
    }

    public function delete(Order $order)
    {
        $order->delete();

        Cart::restoreStock();
    }
}
