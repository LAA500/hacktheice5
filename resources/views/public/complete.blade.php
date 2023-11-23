@extends('layouts.app')

@section('title', 'Ваш заказ оформлен')

@section('content')
<section class="Complete">
    <div class="container">
        <div class="SectionContent">
            <div class="col-md-4 mx-auto">
                <div class="text-center">
                    <div class="my-4">
                        <div>
                            <div class="fs-4 text-success">Ваш заказ оформлен. Спасибо!</div>
                        </div>
                        <div class="mt-4">
                            <div>Заказ № {{$order->id}}</div>
                            <div>от {{$order->created_at->format('d.m.Y, H:i')}}</div>
                        </div>
                        <div class="mt-4">
                            <div>
                                <div>Состав заказа</div>
                            </div>
                            <div>
                                <div>
                                    @foreach($order->products as $product)
                                    <div>{{$product->name}}, {{$product->pivot->quantity}} шт., {{price($product->pivot->price)}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            @auth
                            <a href="{{route('profile.orders')}}" class="btn btn-primary" role="button">Перейти к моим заказам</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection