<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Все публикации</title>
</head>
<body>
<h2>Список постов:</h2>
<table>
    <thead>
    <td>id</td>
    <td>Автор</td>
    <td>Группа</td>
    <td>Текст</td>
    </thead>
    @foreach($posts as $post)
        <tr>
            <td><a href="{{route('post', $post->id)}}">{{$post->id}}</a></td>
            <td>{{$post->user->name}}</td>
            <td>{{$post->group->name}}</td>
            <td>{{\Illuminate\Support\Str::limit($post->text, 50)}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
