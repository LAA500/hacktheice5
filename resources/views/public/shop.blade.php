@extends('layouts.app')

@section('title', $shop->name)

@section('content')
<section class="Shop">
    <div class="container">
        <div class="mb-4">
            <div class="text-center">
                <div class="fs-4 fw-bold">Магазин {{$shop->name}}</div>
                <div>{{$shop->phone_format}}</div>
                <div>{{$shop->address}}</div>
            </div>
        </div>
        <div class="row">
            @foreach($shop->products as $product)
            <x-product-card class="col-md-3" :product="$product"></x-product-card>
            @endforeach
        </div>
    </div>
</section>
@endsection