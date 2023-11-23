<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function setCity(City $city)
    {
        session(['city' => [
            'name' => $city->name,
            'uuid' => $city->uuid,
            'id' => $city->id,
        ]]);

        return redirect()->back();

        return new JsonResponse([
            'success' => true,
            'city' => $city,
        ]);
    }
}
