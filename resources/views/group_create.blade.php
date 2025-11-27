<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GROUP CREATE</title>
</head>
<body>
<h2>Создать группу</h2>
<form method="post" action="{{route('group.store')}}">
    @csrf
    <label>Название группы</label>
    <input type="text" name="name" value="{{old('name')}}">
    @error('name')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Описание</label>
    <input type="text" name="description" value="{{old('description')}}">
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Доступна только подписчикам</label>
    <input type="checkbox" name="private">
<br>
    <input type="submit">
</form>


</body>
</html>
