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
            <td>Приватная</td>
            <td>Действия</td>
        </thead>
    @foreach($groups as $group)
        <tr>
            <td><a href="{{route('group.show', $group->id)}}">{{$group->id}}</a></td>
            <td>{{$group->name}}</td>
            <td>{{$group->description}}</td>
            <td>{{$group->admin->name}}</td>
            <td>{{$group->posts->count()}}</td>
            <td>{{$group->is_private}}</td>
            <td>
                <a href="{{route('group.edit', $group->id)}}">Редактировать</a>
                <form action="{{route('group.destroy',$group->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
    </table>
<br>
    <a href="{{route("group.create")}}">Создать группу</a>
</body>
</html>
