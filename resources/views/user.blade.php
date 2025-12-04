@extends('layout')
@section('content')
<h2>Информация о пользователе {{$user->name}} </h2>
<table class="table table-bordered table-striped">
    <thead>
    <td>id</td>
    <td>Никнейм</td>
    <td>Email</td>
    <td>Статус</td>
    </thead>
    <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->status}}</td>
    </tr>
</table>

<h3>Подписки</h3>
@if(count($user->groups) === 0)
    <p>Нет групп</p>
@else
    <table class="table table-striped table-bordered">
        <thead>
        <td>id</td>
        <td>имя группы</td>
        </thead>
        @foreach($user->groups as $group)
            <tr>
                <td>{{$group->id}}</td>
                <td><a href="{{route('group.show', $group->id)}}"> {{$group->name}}</a></td>
            </tr>
        @endforeach
    </table>
@endif

@endsection
