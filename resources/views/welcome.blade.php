@extends('layout')

@section('stylesheets')
<link rel="stylesheet" href="/css/welcome.css">
@stop

@section('title', "Script Hub - Documentación y Bots")

@section('header_content')
@stop

@section('main_content')
<section class="d-flex flex-column align-items-center justify-content-around justify-content-lg-center h-100vh p-4" id="informacion">
    <img src="/assets/logo-bn.png" alt="Script Hub - Documentación y Bots" class="img-fluid rounded">
    <h1 class="font-weight-light">Programación de bots con Discord en Español.</h1>
    <blockquote class="blockquote text-center p-4">
        <p class="font-italic font-weight-light">"Somos una comunidad de programadores que escribe guías, compartimos nuestras experiencias y ayudamos a responder dudas sobre programación."</p>
        <footer class="blockquote-footer">Script Hub Team</footer>
    </blockquote>
</section>
@stop

@section('footer_section')
@stop

@section('scripts')
<script>
    var logoRotate = anime({
        targets: '#logo-scripthub',
        translateX: '100%',
        rotate: '2turn',
        easing: 'easeInOutQuad'
    });
</script>
@endsection
