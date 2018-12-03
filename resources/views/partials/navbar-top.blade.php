<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('devices.index') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTop">
            <div class="d-flex ml-auto font-weight-bold text-uppercase">
                @if(Auth::check())
                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->getRoleNames()->count())
                        <span class="navbar-text ml-1">- {{ ucfirst(Auth::user()->getRoleNames()[0]) }}</span>
                    @endif
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button class="btn btn-dark font-weight-normal ml-3 text-uppercase" type="submit">Odhlásit</button>
                    </form>
                @else
                    <a class="btn btn-dark font-weight-normal text-uppercase" href="{{ route('auth.login') }}" role="button">Přihlásit</a>
                @endif
            </div>
        </div>
    </div>
</nav>
