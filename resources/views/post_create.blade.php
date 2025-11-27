<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POST CREATE</title>
</head>
<body>
<h2>Добавить пост</h2>
<form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
    @csrf
    <input hidden name="group_id" value="{{$group_id}}">
    <input name="user_id" type="hidden" value="1">
    <label>Текст публикации</label>
    <input type="text" name="text" value="{{old('text')}}">
    @error('text')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Теги</label>
    <input type="text" name="tags" value="{{old('tags')}}">
    @error('tags')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Изображение</label>
    <input type="file" name="image">
    @error('image')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Трек</label>
    <input type="file" name="audio">
    @error('audio')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <input type="submit">
</form>


</body>
</html>
