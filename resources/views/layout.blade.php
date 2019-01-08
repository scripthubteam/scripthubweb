<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="Script Hub - Documentación y Bots">
    <meta property="og:description" content="Programación de bots con Discord en español.">
    <meta property="og:image" content="/assets/server-ui/logo-cord-re.png">
    <meta property="og:url" content="https://scripthubteam.github.io/">
    <meta property="og:site_name" content="Script Hub">
    <meta property="og:type" content="website">

    <!-- Motor de búsqueda -->
    <meta name="description" content="Script Hub - Documentación y Bots">
    <meta name="image" content="/assets/server-ui/logo-cord-re.png">
    <link rel="canonical" href="https://scripthubteam.github.io/" />

    <!-- Schema.org Google -->
    <meta itemprop="name" content="Script Hub - Documentación y Bots">
    <meta itemprop="description" content="Programación de bots con Discord en español.">
    <meta itemprop="image" content="/assets/server-ui/assets/logo-cord-re.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Script Hub - Documentación y Bots">
    <meta name="twitter:description" content="Programación de bots con Discord en español.">
    <meta name="twitter:image" content="/assets/server-ui/logo-cord-re.png">

    <!-- Web Stuff -->
    <link rel="canonical" href="https://scripthubteam.github.io/" />
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Bootstrap Stuff -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Personal Style -->
    <link rel="stylesheet" href="/css/layout.css">

        <title>@yield('title')</title>
</head>
<body>
    <!-- Header Section -->
    <header class="d-flex flex-column align-items-stretch justify-content-center p-3">
        <ul class="nav nav-dark nav-fill align-items-center">
            <li class="nav-item d-none d-sm-block justify-content-center">
                <figure id="logo-scripthub">
                    <img class="w-100" src="/assets/server-ui/logo-cord-raw.png" alt="Logo Script Hub Team">
                </figure>
            </li>
            <li class="nav-item">
                <a href="https://scripthubteam.github.io/docs/" target="_blank" class="nav-link btn btn-info text-light p-3">
                    <span class="fa fa-book"></span> Documentación
                </a>
            </li>
            <li class="nav-item">
                <a href="https://www.patreon.com/scripthubteam" target="_blank" class="nav-link btn text-light p-3 ml-2">
                    <span class="fab fa-patreon"></span> Patreon
                </a>
            </li>
            <li class="nav-item">
                <a href="https://discordapp.com/invite/VK2V7Yk" target="_blank" class="nav-link btn text-light p-3 ml-2">
                    <span class="fab fa-discord"></span> Discord
                </a>
            </li>
            <li class="nav-item">
                <a href="/register/" target="_blank" class="nav-link btn btn-secondary text-light p-3 ml-0 ml-sm-2 mt-2 mt-sm-0">
                    <span class="fas fa-user"></span> Iniciar sesión
                </a>
            </li>
        </ul>
        @yield('header_content')
    </header>

    <!-- Main Section -->
    <main class="d-flex flex-column bg-white align-items-center justify-content-around h-100vh p-4">
        @yield('main_content')
    </main>

    <!-- Footer Section -->
    <footer class="d-flex flex-row">
        @yield('footer_content')
    </footer>

    <!-- Bootstrap Libraries -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
