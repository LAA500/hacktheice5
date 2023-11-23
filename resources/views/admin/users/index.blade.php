@extends('layouts.admin')

@section('content')
<div>
    <div>
        <div class="mb-3">
            <a href="{{route('admin.users.create')}}" class="btn btn-secondary" role="button">Создать</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Фамилия Имя</th>
                        <th>Населенный пункт</th>
                        <th>Номер телефона</th>
                        <th>Email</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><a href="{{route('admin.users.edit', $user)}}">{{$user->name}}</a></td>
                        <td class="small">{{$user->city->name}}</td>
                        <td>{{$user->phone_format}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at->format('d.m.Y, H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection