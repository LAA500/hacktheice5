@extends('layouts.admin')

@section('content')
<div>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Клиент</th>
                        <th>Номер телефона</th>
                        <th>Магазин</th>
                        <th>Всего</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><a href="{{route('admin.orders.edit', $order)}}">{{$order->id}}</a></td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->phone_format}}</td>
                        <td>{{$order->shop->name}}</td>
                        <td>{{price($order->total)}}</td>
                        <td>{{$order->created_at->format('d.m.Y, H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection