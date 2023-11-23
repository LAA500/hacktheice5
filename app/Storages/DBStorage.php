<?php

namespace App\Storages;

use App\Models\DatabaseStorageModel;
use Darryldecode\Cart\CartCollection;

class DBStorage
{
    public function get($key)
    {
        if ($cart = DatabaseStorageModel::find($key)) {
            return new CartCollection($cart->cart_data);
        }

        return [];
    }

    public function put($key, $value)
    {
        if ($row = DatabaseStorageModel::find($key)) {
            $row->cart_data = $value;
            $row->save();
        } else {
            DatabaseStorageModel::create([
                'id' => $key,
                'cart_data' => $value,
            ]);
        }
    }
}
