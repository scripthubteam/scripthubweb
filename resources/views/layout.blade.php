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
    <meta property="og:image" content="./docs/assets/server-ui/logo-cord-re.png">
    <meta property="og:url" content="https://scripthubteam.github.io/">
    <meta property="og:site_name" content="Script Hub">
    <meta property="og:type" content="website">

    <!-- Motor de búsqueda -->
    <meta name="description" content="Script Hub - Documentación y Bots">
    <meta name="image" content="./docs/assets/server-ui/logo-cord-re.png">
    <link rel="canonical" href="https://scripthubteam.github.io/" />

    <!-- Schema.org Google -->
    <meta itemprop="name" content="Script Hub - Documentación y Bots">
    <meta itemprop="description" content="Programación de bots con Discord en español.">
    <meta itemprop="image" content="./docs/assets/server-ui/assets/logo-cord-re.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Script Hub - Documentación y Bots">
    <meta name="twitter:description" content="Programación de bots con Discord en español.">
    <meta name="twitter:image" content="./docs/assets/server-ui/logo-cord-re.png">

    <!-- Web Stuff -->
    <link rel="canonical" href="https://scripthubteam.github.io/" />
    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Bootstrap Stuff -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <title>@yield('title')</title>
</head>
<body>
    <!-- Header Section -->
    <header>
        @yield('header_content')
    </header>

    <!-- Main Section -->
    <main>
        @yield('main_content')
    </main>

    <!-- Footer Section -->
    <footer>
        @yield('footer_content')
    </footer>

    <!-- Bootstrap Libraries -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
