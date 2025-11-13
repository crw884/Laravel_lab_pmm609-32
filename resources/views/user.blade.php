<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$user->name}}</title>
</head>
<body>
<h2>Информация о пользователе</h2>
<table>
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

<h3>Группы:</h3>
@if(count($user->groups) === 0)
    <p>Нет групп</p>
@else
    <table>
        <thead>
        <td>id</td>
        <td>имя группы</td>
        </thead>
        @foreach($user->groups as $group)
            <tr>
                <td>{{$group->id}}</td>
                <td>{{$group->name}}</td>
            </tr>
        @endforeach
    </table>
@endif

</body>
</html>
