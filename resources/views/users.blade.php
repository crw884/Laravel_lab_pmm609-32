<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
</head>
<body>
<h2>Список пользователей:</h2>
<table>
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
            <td>{{$user->status}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
