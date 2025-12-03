@extends('layout')
@section('content')
    <div class="d-flex flex-column align-items-center border-1 border-dark border p-3 mt-5 bg-dark bg-opacity-10"
         style="border-radius: 20px;">
        @if($user)
            <h2>Здравствуйте {{$user->name}}</h2>
            <a href="{{route("logout")}}">Выйти из системы</a>
        @else
            <h2>Вход в систему</h2>
            <form action="{{route("authenticate")}}" method="post"
                  class="d-flex flex-column align-items-center ">
            @csrf
                <label>E-mail</label>
                <input type="text" name="email" value="{{old('email')}}"
                       style="width: 300px; height: 40px; border-radius: 8px;
                              border-width: 1px; padding-left: 10px;">
                @error('email')
                <div class="is-invalid">{{$message}}</div>
                @enderror
                <br>
                <label>Пароль</label>
                <input type="password" name="password" value="{{old('password')}}"
                       style="width: 300px; height: 40px; border-radius: 8px;
                       border-width: 1px; padding-left: 10px;">
                @error('password')
                <div class="is-invalid">{{$message}}</div>
                @enderror
                <br>
                <button type="submit" class="mt-3 btn btn-primary">Войти в аккаунт</button>
            </form>
            @error('error')
            <div class="is-invalid">{{$message}}</div>
            @enderror
        @endif
   </div>
@endsection
