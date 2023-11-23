@extends('layouts.admin')

@section('content')
<div>
    <div>
        <div class="mb-3">
            <a href="{{route('admin.products.create')}}" class="btn btn-secondary" role="button">Создать</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Категория</th>
                        <th>Наличие</th>
                        <th>Цена</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td><a href="{{route('admin.products.edit', $product)}}">{{$product->name}}</a></td>
                        <td>{{$product->category->name}}</td>
                        <td class="small {{$product->in_stock ? 'text-success' : 'text-danger'}}">{{$product->in_stock ? 'Есть в наличии' : 'Нет в наличии' }}</td>
                        <td>{{price($product->price)}}</td>
                        <td>{{$product->created_at->format('d.m.Y, H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection