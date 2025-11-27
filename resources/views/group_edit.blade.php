<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GROUP EDIT</title>
</head>
<body>
<h2>Редактировать группу</h2>
<form method="post" action="{{route('group.update', $group->id)}}">
    @csrf
    @method('PUT')
    <label>Редактировать описание</label>
    <input type="text" name="description" value="{{$group->description}}">
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <label>Доступна только подписчикам</label>
    <input type="checkbox" name="private" @if($group->is_private) checked @endif value="on">
    <br>
    <input type="submit">
</form>


</body>
</html>
