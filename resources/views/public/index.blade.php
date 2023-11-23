@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container">
    <div>
        <div class="row">
            @foreach($city->shops as $shop)
            <div class="col-md-4">
                <div class="Shop-card">
                    <a href="{{route('shop', $shop)}}">
                        <div>
                            <div class="Shop-card-name">
                                <div>{{$shop->name}}</div>
                            </div>
                            <div class="Shop-card-address">
                                <div>{{$shop->address}}</div>
                            </div>
                            <div class="Shop-card-phone">
                                <div>{{$shop->phone_format}}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection