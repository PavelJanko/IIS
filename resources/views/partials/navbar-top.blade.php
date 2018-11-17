<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="{{ route('homepage') }}">{{ env('APP_NAME') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    Dropdown
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        @if(Auth::check())
            @hasrole('administrator')
                <a class="btn btn-primary mr-2" href="#" role="button">Speciální</a>
            @endhasrole
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button class="btn btn-primary" type="submit">Odhlásit</button>
            </form>
        @else
            <a class="btn btn-primary" href="{{ route('auth.login') }}" role="button">Přihlásit</a>
        @endif
    </div>
    </div>
</nav>
