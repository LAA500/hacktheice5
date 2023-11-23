@extends('layouts.admin')

@section('content')
<div>
    <div>
        <div class="mb-3">
            <a href="{{route('admin.categories.create')}}" class="btn btn-secondary" role="button">Создать</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Кол-во товаров</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td><a href="{{route('admin.categories.show', $category)}}">{{$category->name}}</a></td>
                        <th>{{$category->products->count()}}</td>
                        <td>{{$category->created_at->format('d.m.Y, H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection