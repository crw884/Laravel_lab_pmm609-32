@extends('layout')
@section('content')
    <h2>Информация о группе:</h2>
    <table class="w-75 table table-striped table-bordered">
        <thead>
        <td>id</td>
        <td>Название</td>
        <td>Описание</td>
        <td>Админ</td>

        </thead>
        <tr>
            <td>{{$group->id}}</td>
            <td>{{$group->name}}</td>
            <td>{{$group->description}}</td>
            <td>{{$group->admin->name}}</td>
        </tr>
    </table>
    @if(Auth::id() === $group->admin->id)
        <div class="d-flex flex-row gap-2 w-50">
        <a href="{{route('group.edit', $group->id)}}" class="btn btn-warning w-50 mb-2">Редактировать</a>
        <form action="{{route('group.destroy',$group->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">Удалить группу</button>
        </form>
        </div>
    @endif

    <h3>Подписчики:</h3>
    @if(count($group->users) === 0)
        <p>Нет подписчиков</p>
    @else
        <table class="table table-striped table-bordered w-75">
            <thead>
            <td>id</td>
            <td>Никнейм</td>
            </thead>
            @foreach($group->users as $sub)
                <tr>
                    <td>{{$sub->id}}</td>
                    <td>{{$sub->name}}</td>
                </tr>
            @endforeach
        </table>
    @endif
    @if(Auth::check())
        @if($group->users()->where('user_id', Auth::id())->exists())
            <form action="{{route('group.unsubscribe',$group->id)}}" method="post">
                @csrf
                <button class="btn btn-danger">Отписаться</button>
            </form>
        @else
            <form action="{{route('group.subscribe',$group->id)}}" method="post">
                @csrf
                <button class="btn btn-success">Подписаться</button>
            </form>
        @endif

    @endif


    <h3 class="mb-3">Публикации:</h3>
    @if(count($group->posts) === 0)
        <p >Нет публикаций</p>
    @else
        <div class="d-flex flex-column align-items-baseline">
            @foreach($group->posts as $post)
                <div style="width: 385.2px;" class="d-flex flex-column align-items-baseline
                                            border border-2 rounded-3 p-3">
                    <span>{{$post->created_at}}</span>
                    @if($post->image)
                        <img src="{{route('post.image', $post->id)}}" alt="Загрузка..."
                             style="width: 350px; height: 350px">
                    @endif
                    @if($post->audio)
                        <p>
                            <audio controls style="width: 350px">
                                <source src="{{route('post.audio', $post->id)}}">
                            </audio>
                        </p>
                    @endif
                    <p class="">{{$post->text}}</p>
                    <a href="{{route('post.show', $post->id)}}">открыть пост</a>
                </div>
                <hr style="height: 1px; width: 385.2px; color: black;">
            @endforeach
        </div>
    @endif

    @if($group->users->contains('id', Auth::id()) OR $group->admin->id === Auth::id())
        <a href="{{route('post.create', $group->id)}}" class="btn btn-primary mb-4">Создать пост</a>
    @endif

@endsection
