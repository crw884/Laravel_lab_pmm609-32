@extends('layout')
@section('content')
<h2>Список пользователей:</h2>
<table class="table table-striped table-bordered">
    <thead>
    <td>id</td>
    <td>Никнейм</td>
    <td>Email</td>
    <td>Статус</td>
    </thead>
    @foreach($users as $user)
        <tr>
            <td><a href="{{route('user.show', $user->id)}}">{{$user->id}}</a></td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            @if(\Illuminate\Support\Str::length($user->status) > 0)
                <td>{{$user->status}}</td>
            @else
                <td><i>Нет статуса.</i></td>
            @endif

        </tr>
    @endforeach
</table>

@endsection
