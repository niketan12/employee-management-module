<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-nh9KjptUuJ2ltA0qKcdEJx7l7QEPu+85d9gVmwZQD1yvlF5R6OJsFt3f7+PtsvU2" crossorigin="anonymous"> -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="d-flex min-vh-100 bg-light">
    @unless(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.email') || request()->routeIs('password.reset'))
        @include('partials.sidebar')
    @endunless

    <div class="flex-grow-1">
        @include('partials.header')

        <main class="container py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-xfAhk2KgZ8drS8f/UAYZ7fK+KdSyojo7TXC3LUrbsXNXtdNucYyfzjDf8o0FUEQM" crossorigin="anonymous"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
