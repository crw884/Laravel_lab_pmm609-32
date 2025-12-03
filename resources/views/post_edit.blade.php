@extends('layout')
@section('content')
<body>

<form method="post" action="{{route('post.update', $post->id)}}"
      class="d-flex flex-column align-items-center gap-2 border-1 border-dark border p-4 mt-5 bg-dark bg-opacity-10"
      style="border-radius: 20px;">
    <h2 >Редактировать публикацию</h2 >
    @csrf
    @method('PUT')
    <label >Редактировать текст поста</label>
    <textarea class="w-100" type="text" name="text">{{old('text')}}</textarea>
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <button type="submit" class="btn btn-info">Сохранить изменения</button>
</form>

@endsection
