<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Публикация {{$post->id}}</title>
</head>
<body>
    <h2>id: {{$post->id}}</h2>

    <p>Автор: {{$post->user->name}}</p>
    <p>Группа: {{$post->group->name}}</p>

    <p>{{$post->text}}</p>
    <img src="{{route('post.image', $post->id)}}" alt="" style="width: 300px; height: 300px">
    <p>
        <audio controls>
            <source src="{{route('post.audio', $post->id)}}">
        </audio>
    </p>

@if(count($comments) > 0)
    <p>Комментарии:</p>
    <table>
        <thead>
        <td>id</td>
        <td>Автор</td>
        <td>Комментарий</td>
        <td>Дата</td>
        </thead>
        @foreach($comments as $comment)
            <tr>
                <td>{{$comment->id}}</td>
                <td>{{$comment->user->name}}</td>
                <td>{{$comment->text}}</td>
                <td>{{$comment->created_at}}</td>
            </tr>
        @endforeach
    </table>
@endif

<h3>Рейтинг: {{number_format($rating, 1)}}</h3>
</body>
</html>
