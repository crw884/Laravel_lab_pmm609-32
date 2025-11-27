<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Публикация {{$post->id}}</title>
</head>
<body>
    <h2>id: {{$post->id}}</h2>

    <p>Автор: {{$post->user->name}}</p>
    <a href="{{route('group.show', $post->group->id)}}">Группа: {{$post->group->name}}</a>

    <p>{{$post->text}}</p>
    @if($post->image)
        <img src="{{route('post.image', $post->id)}}" alt="" style="width: 300px; height: 300px">
    @endif

    @if($post->audio)
        <p>
            <audio controls>
                <source src="{{route('post.audio', $post->id)}}">
            </audio>
        </p>
    @endif
    <a href="{{route('post.edit', $post->id)}}">Редактировать пост</a>
    <form action="{{route('post.destroy',$post->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Удалить</button>
    </form>

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
