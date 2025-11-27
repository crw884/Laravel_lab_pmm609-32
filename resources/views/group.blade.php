<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$group->name}}</title>
</head>
<body>
<h2>Информация о группе:</h2>
<table>
    <thead>
    <td>id</td>
    <td>Название</td>
    <td>Описание</td>
    <td>Админ</td>

    </thead>
    <tr>
        <td>{{$group->id}}</td>
        <td>{{$group->name}}</td>
        <td>{{$group->description}}</td>
        <td>{{$group->admin->name}}</td>

    </tr>
</table>

<h3>Подписчики:</h3>
@if(count($group->users) === 0)
    <p>Нет подписчиков</p>
@else
    <table>
        <thead>
        <td>id</td>
        <td>Никнейм</td>
        </thead>
        @foreach($group->users as $sub)
            <tr>
                <td>{{$sub->id}}</td>
                <td>{{$sub->name}}</td>
            </tr>
        @endforeach
    </table>
@endif

<h3>Публикации:</h3>
@if(count($group->posts) === 0)
    <p>Нет публикаций</p>
@else
    <table>
        <thead>
        <td>id</td>
        <td>Текст</td>
        </thead>
        @foreach($group->posts as $post)
            <tr>
                <td><a href="{{route('post.show', $post->id)}}">{{$post->id}}</a></td>
                <td>{{\Illuminate\Support\Str::limit($post->text, 50)}}</td>
            </tr>
        @endforeach
    </table>
@endif

<a href="{{route('post.create', $group->id)}}">Создать пост</a>
</body>
</html>
