@extends('layouts.app')

@section('title', $shop->name)

@section('content')
<section class="Shop">
    <div class="container">
        <div class="row">
            @foreach($shop->products as $product)
            <x-product-card class="col-md-4" :product="$product"></x-product-card>
            @endforeach
        </div>
    </div>
</section>
@endsection