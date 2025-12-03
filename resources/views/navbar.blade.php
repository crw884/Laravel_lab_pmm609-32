<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{url('/posts')}}">Soundclown</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('post.index')}}">Посты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('group.index')}}">Группы</a>
                    </li>
                </ul>
                @if(!Auth::check())
                    <a href="{{route('login')}}" class="link-primary btn btn-outline-error my-2">Войти</a>
                @else
                    <ul class="navbar-nav d-flex align-items-center">
                        <li>
                            <a class="nav-link active" href="{{route("user.show", Auth::id())}}">
                                <i class="fa fa-user" style="font-size:20px;color:white;"></i>
                                {{Auth::user()->name}}</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-success my-2 my-sm-8" href="{{route('logout')}}">Выйти</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
</header>
