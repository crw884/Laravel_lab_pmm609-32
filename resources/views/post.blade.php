@extends('layout')
@section('content')
<div class="w-75 d-flex flex-column align-items-center">
    <p class="mb-3">Автор: {{$post->user->name}}</p>
    <div class="d-flex flex-row w-50 gap-2 mb-2">
    @if($post->user->id === Auth::id())
        <a href="{{route('post.edit', $post->id)}}" class="btn btn-warning">
            Редактировать
        </a>
        <form action="{{route('post.destroy',$post->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">Удалить</button>
        </form>
    @endif
    </div>
    <p><a href="{{route('group.show', $post->group->id)}}">{{$post->group->name}}</a></p>

    <div>
        @if($post->image)
            <img src="{{route('post.image', $post->id)}}" alt="" style="width: 350px; height: 350px">
        @endif

        @if($post->audio)
            <p class="mb-0" >
                <audio controls style="width: 350px;">
                    <source src="{{route('post.audio', $post->id)}}">
                </audio>
            </p>
        @endif
        <p class="text-break" style="width: 350px;">{{$post->text}}</p>
    </div>
    <div class="w-75 d-flex flex-column">
        @if(Auth::check())
            <form action="{{route('comment.store', $post->id)}}" method="post" class="w-100 d-flex flex-column gap-3 align-items-center">
                @csrf
                <textarea class="w-100" name="comment" placeholder="Комментарий..."></textarea>
                <button type="submit" class="w-50 btn btn-primary rounded-3">Отправить</button>
            </form>
        @endif
    </div>


    @if(count($comments) > 0)
        <h6 class="mt-4 mb-0">Комментарии</h6>
        <div class="w-75 d-flex flex-column mt-3">
        @foreach($comments as $comment)
            <div class="d-flex flex-column align-items-baseline">
                <div class="d-flex flex-row gap-2">
                    <a href="{{route('user.show', $comment->user->id)}}">{{$comment->user->name}} </a>
                    <span>{{$comment->created_at}}</span>
                </div>
                <p class="text-break">{{$comment->text}}</p>

            </div>
            <br>
        @endforeach
        </div>
    @endif

</div>
@endsection
