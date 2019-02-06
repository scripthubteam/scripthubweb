<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="Script Hub - Documentación y Bots">
    <meta property="og:description" content="Programación de bots con Discord en español.">
    <meta property="og:image" content="{{ url('/').'/assets/server-ui/logo-cord-re.png' }}">
    <meta property="og:url" content="https://scripthubteam.github.io/">
    <meta property="og:site_name" content="Script Hub">
    <meta property="og:type" content="website">

    <!-- Motor de búsqueda -->
    <meta name="description" content="Script Hub - Documentación y Bots">
    <meta name="image" content="{{ url('/')."/assets/server-ui/logo-cord-re.png" }}">
    <link rel="canonical" href="https://scripthubteam.github.io/" />

    <!-- Schema.org Google -->
    <meta itemprop="name" content="Script Hub - Documentación y Bots">
    <meta itemprop="description" content="Programación de bots con Discord en español.">
    <meta itemprop="image" content="{{ url('/').'/assets/server-ui/assets/logo-cord-re.png' }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Script Hub - Documentación y Bots">
    <meta name="twitter:description" content="Programación de bots con Discord en español.">
    <meta name="twitter:image" content="{{ url('/').'/assets/server-ui/logo-cord-re.png' }}">

    <!-- Web Stuff -->
    <link rel="canonical" href="https://scripthubteam.github.io/" />
    <link rel="shortcut icon" href="{{ url('/').'/favicon.png' }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Bootstrap Stuff -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Personal Style -->
    <link rel="stylesheet" href="{{ url('/').'/css/layout.css' }}">
    @yield('stylesheets')

    <title>{{ Config::get('app.name', 'Script Hub Team') }} - @yield('title')</title>
</head>
<body class="bg-primary">
    {{-- Checking if User is in Home --}}
    @if (Request::route()->getName() != 'root')
        @php ($link = route('root'))
    @else
        @php ($link = "")
    @endif
    <!-- Navigator -->
    <nav class="navbar navbar-expand-lg sticky-top bg-primary" id="navigatorHeader">
        <div class="container">
            <a href="{{ route('root') }}" class="navbar-brand" id="logo-scripthub">
                <img src="{{ url('/').'/assets/server-ui/logo-cord-raw.png' }}" alt="Logo Script Hub Team">
            </a>
            <button class="navbar-toggler navbar-toggler-right text-light border border-light" type="button" data-toggle="collapse" data-target="#navigatorMenu" aria-controls="navigatorMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fas fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="navigatorMenu">
                <ul class="navbar-nav navbar-dark ml-auto">
                    <li class="nav-item mt-2 mt-lg-0 ml-0 ml-lg-2">
                        <a href="{{ route('root') }}" class="nav-link btn pt-lg-2" id="itemInfo">
                            <span class="fas fa-info"></span> Información
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ml-0 ml-lg-2">
                        <a href="{{ $link."#documentacion" }}" class="nav-link btn text-light pt-lg-2" id="itemDoc">
                            <span class="fa fa-book"></span> Documentación
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ml-0 ml-lg-2">
                        <a href="https://www.patreon.com/scripthubteam" target="_blank" class="nav-link btn text-light pt-lg-2" id="itemPatreon">
                            <span class="fab fa-patreon"></span> Patreon
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0 ml-0 ml-lg-2">
                        <a href="https://discordapp.com/invite/VK2V7Yk" target="_blank" class="nav-link btn text-light pt-lg-2" id="itemDiscord">
                            <span class="fab fa-discord"></span> Discord
                        </a>
                    </li>
                        @guest
                            <li class="nav-item mt-2 mt-lg-0 ml-0 ml-lg-2">
                                <a href="{{ route('login') }}" class="nav-link btn text-light pt-lg-2" id="itemLogin">
                                    <span class="fas fa-user"></span> Iniciar sesión
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown mt-2 mt-lg-0 ml-0 ml-lg-2">
                                <a class="nav-link dropdown-toggle btn text-light pt-lg-2" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="itemLogin">
                                    <span class="fas fa-user"></span> {{ Auth::user()->username }}
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('home') }}" class="dropdown-item">
                                        <span class="fas fa-home"></span> Home
                                    </a>
                                    <a href="{{ route('bots.index') }}" class="dropdown-item">
                                        <span class="fas fa-users-cog"></span> Bots
                                    </a>
                                    <a href="{{ route('users.bots', Auth::user()) }}" class="dropdown-item">
                                        <span class="fas fa-user-tag"></span> Tus Bots
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <span class="fas fa-sign-out-alt"></span> Salir
                                    </a>
                                    {{ Form::open([
                                        'route' => 'logout',
                                        'class' => 'd-none',
                                        'id' => 'logout-form'
                                    ]) }}
                                    @csrf
                                    {{ Form::close() }}
                                </div>
                            </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="header bg-primary">
        @yield('header_content')
    </header>

    <!-- Main Section -->
    <main class="main bg-white">
        @yield('main_content')
    </main>

    <!-- Footer Section -->
    <footer class="footer bg-primary sticky-bottom">
        <div class="container p-3">
            <p class="text-center text-light font-italic">&copy; Script Hub Team 2019. All Rights Reserved.</p>
            <ul class="list-inline d-flex flex-row justify-content-center">
                <li class="list-inline-item">
                    <a class="link text-light" target="_blank" href="https://github.com/scripthubteam">Script Hub Team GitHub</a>
                </li>
                <li class="list-inline-item">
                    <a class="link text-light" target="_blank" href="https://scripthubteam.github.io/docs/">Documentación</a>
                </li>
                <li class="list-inline-item">
                    <a class="link text-light" target="_blank" href="https://www.patreon.com/scripthubteam">Patreon</a>
                </li>
                <li class="list-inline-item">
                    <a class="link text-light" target="_blank" href="https://discordapp.com/invite/VK2V7Yk">Discord</a>
                </li>
            </ul>
        </div>
        @yield('footer_content')
    </footer>

    <!-- Bootstrap Libraries -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <!-- AnimeJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>
    @yield('scripts')
</body>
</html>
