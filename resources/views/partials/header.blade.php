<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
    <!-- <a class="navbar-brand" href="{{ route('dashboard') }}">{{ config('app.name') }}</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            @auth
                <li class="nav-item">
                    <span class="nav-link text-white">{{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
                    </form>
                </li>
            @else
                <!-- <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">Register</a></li> -->
            @endauth
        </ul>
    </div>
</nav>
