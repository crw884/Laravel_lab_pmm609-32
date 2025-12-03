@extends('layout')
@section('content')

<form method="post" action="{{route('group.update', $group->id)}}"
      class="d-flex flex-column gap-2 w-75 align-items-center border-1 border-dark border p-3 mt-5 bg-dark bg-opacity-10"
      style="border-radius: 20px;">
    <h2 class="" style="font-size: 26px;">Редактировать группу {{$group->name}}</h2>
    @csrf
    @method('PUT')
    <label class="w-100">Редактировать описание</label>
    <input type="text" name="description" value="{{$group->description}}" class="w-100">
    @error('description')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <div class="gap-2 d-flex flex-row w-100">
        <input id="private" type="checkbox" name="private" @if($group->is_private) checked @endif value="on"
            >
        <label for="private">Доступна только подписчикам</label>
    </div>

    <br>
    <button type="submit" class="btn btn-info w-50">Редактировать группу</button>
</form>

@endsection
