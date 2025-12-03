@extends('layout')
@section('content')
    <style>
        .pagination{
            margin-bottom: 0;

            li{
                margin-left: 5px;
                margin-right: 5px;
                display: flex;
                align-items: center;
                margin-bottom: 0;
            }
        }
    </style>
    <h2 class="d-flex justify-content-center mb-4">
        Все публикации
    </h2>
    <div class="d-flex flex-column align-items-baseline">
    @foreach($posts as $post)


        <div style="width: 385.2px;" class="d-flex flex-column align-items-baseline
                                            border border-2 rounded-3 p-3">
            <a class="mb-2" href="{{route('group.show', $post->group_id)}}">{{$post->group->name}}</a>
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
            <p class="text-break">{{$post->text}}</p>
            <a href="{{route('post.show', $post->id)}}">открыть пост</a>
        </div>
        @if($loop->last)
            <div class="mb-4"></div>
        @else
            <hr style="height: 1px; width: 385.2px; color: black;">
        @endif


    @endforeach
    </div>
    {{$posts->links()}}
@endsection
