@extends('layout')
@section('content')

<form method="post" action="{{route('group.store')}}"
      class="d-flex flex-column gap-2 w-75 align-items-center border-1 border-dark border p-3 mt-5 bg-dark bg-opacity-10"
      style="border-radius: 20px;">
    <h2>Создать группу</h2>
    @csrf
    <label class="w-100">Название группы</label>
    <input type="text" name="name" value="{{old('name')}}" class="w-100">
    @error('name')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <label class="w-100">Описание</label>
    <input type="text" name="description" value="{{old('description')}}" class="w-100">
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
<br>
    <div>
        <input id="private" type="checkbox" name="private">
        <label for="private">Доступна только подписчикам</label>
    </div>
<br>
    <button class="btn btn-primary w-50" type="submit" >Создать группу</button>
</form>

@endsection
