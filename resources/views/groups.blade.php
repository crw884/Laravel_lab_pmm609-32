@extends('layout')
@section('content')
    <h2>Группы</h2>
    <table class="table-bordered table table-striped mt-3">
        <thead>
            <td>id</td>
            <td>Название</td>
            <td>Описание</td>
            <td>Админ</td>

            <td>Приватная</td>
            @if(Auth::check())
                <td>Действия</td>
            @endif
        </thead>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('group.show', $group->id)}}">{{$group->id}}</a></td>
                <td>{{$group->name}}</td>
                <td>{{$group->description}}</td>
                <td>{{$group->admin->name}}</td>

                @if($group->is_private)
                    <td>да</td>
                @else
                    <td>нет</td>
                @endif

                @if(Auth::check())

                <td>
                    @if(Auth::id() === $group->admin->id)
                        <a href="{{route('group.edit', $group->id)}}" class="btn btn-warning w-100 mb-2">Редактировать</a>
                        <form action="{{route('group.destroy',$group->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Удалить</button>
                        </form>
                    @else
                        <div>Доступно только администратору группы</div>
                    @endif

                </td>
                @endif
            </tr>
        @endforeach
    </table>
    @if(Auth::check())
        <a href="{{route("group.create")}}" class="btn btn-primary mt-3">Создать группу</a>
    @endif


@endsection
