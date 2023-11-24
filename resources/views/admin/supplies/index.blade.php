@extends('layouts.admin')

@section('content')
<div>
    <div>
        @if(false)
        <div class="mb-3">
            <a href="{{route('admin.supplies.create')}}" class="btn btn-secondary" role="button">Создать</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ поставки</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplies as $supply)
                    <tr>
                        <td><a href="{{route('admin.supplies.edit', $supply)}}">{{$supplies->number}}</a></td>

                        <td>{{$supply->created_at->format('d.m.Y, H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Нужно</th>
                            <th>Остаток</th>
                            <th>Срок годности</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{(int)$product->need_quantity}}</td>
                            <td class="fw-bold {{(int)$product->quantity < '50%' ? 'text-danger': 'text-success'}}">{{(int)$product->quantity}}</td>
                            <td>истекает, через {{round($product->need_quantity + $product->quantity / 3, 0)}} дней</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection