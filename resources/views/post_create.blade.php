@extends('layout')
@section('content')

<form method="post" action="{{route('post.store')}}" enctype="multipart/form-data"
      class="d-flex flex-column gap-2 w-75 align-items-center border-1 border-dark border p-3 mt-5 bg-dark bg-opacity-10"
      style="border-radius: 20px;">
    <h2 class="mb-3">Добавить пост</h2>
    @csrf
    <input hidden name="group_id" value="{{$group_id}}">
    <input name="user_id" type="hidden" value="1">
    <label>Текст публикации</label>
    <textarea name="text" class="w-100">{{old('text')}}</textarea>

    @error('text')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label hidden for="tags">Теги</label>
    <input id="tags" type="hidden" name="tags" value="{{old('tags')}}"  class="w-100">
    @error('tags')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Изображение</label>
    <input type="file" name="image" class="w-50">
    @error('image')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label>Трек</label>
    <input type="file" name="audio" class="w-50">
    @error('audio')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <button type="submit" class="w-50 btn btn-primary">Создать</button>
</form>

@endsection
