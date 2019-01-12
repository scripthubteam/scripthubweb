@extends('layout')

@section('stylesheets')
<link rel="stylesheet" href="/css/welcome.css">
@stop

@section('title', "Script Hub - Documentación y Bots")

@section('main_content')
<section class="informacion bg-white text-center" id="informacion">
    <div class="container-fluid h-lg-100vh">
        <div class="row align-items-center justify-content-center p-5">
            <img src="{{ url('/').'/assets/logo-bn.png' }}" alt="Script Hub - Documentación y Bots" class="img-fluid rounded">
        </div>
        <div class="row align-items-center justify-content-center">
                <h2 class="font-weight-light col-11 col-sm-8">Programación de bots con Discord en Español.</h2>
                <div class="w-100"></div>
                <blockquote class="blockquote text-center col-11 col-sm-8 mt-5">
                    <p class="font-italic font-weight-light">"Somos una comunidad de programadores que escribe guías, compartimos nuestras experiencias y ayudamos a responder dudas sobre programación."</p>
                    <footer class="blockquote-footer">Script Hub Team</footer>
                </blockquote>
        </div>
    </div>
</section>
<section class="documentacion text-center" id="documentacion">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center py-5">
            <h2 class="text-white col-11 col-sm-8">¡Empieza hoy a crear tu Bot!</h2>
            <div class="w-100"></div>
            <p class="font-weight-light text-light col-11 col-sm-8 mt-3">
                Con nuestra documentación puedes poner en marcha tu bot hoy mismo.
            </p>
        </div>
        <div class="row align-items-center justify-content-center">
            <a href="https://scripthubteam.github.io/docs/" class="btn border border-light text-light col-8 py-3 py-sm-4" target="_blank">
                <span class="fa fa-book"></span> Documentación
            </a>
        </div>
        <div class="row align-items-around align-items-sm-start justify-content-center justify-content-md-around p-sm-5">
            <h3 class="text-weight-light text-black-50 col-11 col-sm-8 mt-3 mt-sm-0">¿Buscas algo más específico?</h3>
            <div class="w-100 mt-5"></div>
            <div class="d-flex flex-column justify-content-center col-10 col-md-3 ml-md-2 my-2 my-md-0">
                <a href="https://scripthubteam.github.io/docs/#/py/discord-py" target="_blank" class="btn border border-light text-light py-2 py-md-3">
                    <i class="fab fa-python"></i> Discord.py
                </a>
                <p class="text-light text-sm-start my-3 my-md-0">
                    <a href="https://www.python.org/" target="_blank" class="link text-light">Python</a> es un lenguaje de programación
                    muy flexible, poderoso y fácil de aprender.<br>
                    Con <a href="https://github.com/Rapptz/discord.py" target="_blank" class="link text-light">discord.py</a> puedes poner
                    tu bot en marcha muy poco tiempo.
                </p>
            </div>
            <div class="d-flex flex-column col-10 col-md-3 ml-md-2 my-2 my-md-0">
                <a href="https://scripthubteam.github.io/docs/#/java/jda" target="_blank" class="btn border border-light text-light py-2 py-md-3">
                    <i class="fab fa-java"></i> JDA
                </a>
                <p class="text-light text-sm-start my-3 my-md-0">
                    <a href="https://www.oracle.com/technetwork/java/javase/downloads/index.html" target="_blank" class="link text-light">Java</a>
                    es un poderoso lenguaje orientado a objetos de tipografía fuerte.<br>
                    Es lenguaje ideal para que el número de errores posibles sea mínimo y con <a href="https://github.com/DV8FromTheWorld/JDA" class="link text-light">JDA</a>
                    la creación de un bot es muy sencilla.
                </p>
            </div>
            <div class="d-flex flex-column col-10 col-md-3 ml-md-2 my-2 my-md-0">
                <a href="https://scripthubteam.github.io/docs/#/js/discord-js" target="_blank" class="btn border border-light text-light py-2 py-md-3">
                    <i class="fab fa-js"></i> Discord.js
                </a>
                <p class="text-light text-sm-start my-3 my-md-0">
                    <a href="https://www.javascript.com/" class="link text-light" target="_blank">JavaScript</a> es un lenguaje que
                    ha extendido su uso más allá de la web gracias a NodeJS.<br>
                    <a href="https://github.com/discordjs/discord.js" class="link text-light" target="_blank">Discord.js</a> es una flexible librería que
                    aprovecha todas la comodidades del lenguaje para crear un bot.
                </p>
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
<script src="{{ url('/').'/js/home.js' }}"></script>
@endsection
