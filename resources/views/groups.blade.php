<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Группы</title>
</head>
<body>
    <h2>Список групп:</h2>
    <table>
        <thead>
            <td>id</td>
            <td>Название</td>
            <td>Описание</td>
            <td>Админ</td>
            <td>Кол-во постов</td>
        </thead>
    @foreach($groups as $group)
        <tr>
            <td><a href="{{route('group', $group->id)}}">{{$group->id}}</a></td>
            <td>{{$group->name}}</td>
            <td>{{$group->description}}</td>
            <td>{{$group->admin->name}}</td>
            <td>{{$group->posts->count()}}</td>
        </tr>
    @endforeach
    </table>
</body>
</html>
