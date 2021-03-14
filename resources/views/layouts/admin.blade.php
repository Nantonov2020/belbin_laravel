<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belbin</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div class="container-fluid d-flex flex-column min-vh-100">

    <x-header></x-header>

    <div class="row">
        <div class="col-2 bg-white h-100">
            <x-adminnav></x-adminnav>
        </div>
        <div class="col-10 bg-light">

            @yield('content')

        </div>
    </div>

    <x-footer></x-footer>

</div>
@stack('scripts')
</body>
</html>
