<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('overview') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="ml-auto">
                @if(Auth::check())
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button class="btn btn-dark font-weight-normal text-uppercase" type="submit">Odhlásit</button>
                    </form>
                @else
                    <a class="btn btn-dark font-weight-normal text-uppercase" href="{{ route('auth.login') }}" role="button">Přihlásit</a>
                @endif
            </div>
        </div>
    </div>
</nav>
