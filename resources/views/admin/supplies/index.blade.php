@extends('layouts.admin')

@section('content')
<div>
    <div>
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
    </div>
</div>
@endsection