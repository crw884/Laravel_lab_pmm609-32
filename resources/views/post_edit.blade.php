<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>POST EDIT</title>
</head>
<body>
<h2>Редактировать публикацию</h2>
<form method="post" action="{{route('post.update', $post->id)}}">
    @csrf
    @method('PUT')
    <label>Редактировать текст поста</label>
    <input type="text" name="text" value="{{$post->description}}">
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <input type="submit">
</form>


</body>
</html>
