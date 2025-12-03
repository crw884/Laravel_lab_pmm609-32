<div class="container w-auto" style="margin-top: 80px">
    @if(session('error'))
        <div class="alert alert-danger px-5" role="alert">
            {{session('error')}}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success px-5" role="alert">
            {{session('success')}}
        </div>
    @endif
</div>

