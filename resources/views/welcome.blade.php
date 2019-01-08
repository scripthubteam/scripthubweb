@extends('layout')

@section('title', "Script Hub - Documentación y Bots")

@section('header_content')
@stop

@section('main_content')
    <figure class="figure">
        <img src="/assets/logo-bn.png" alt="Script Hub - Documentación y Bots" class="figure-img img-fluid">
    </figure>
    <h1 class="font-weight-light">Programación de bots con Discord en Español.</h1>
    <blockquote class="blockquote text-center p-4">
        <p class="font-italic font-weight-light">"Somos una comunidad de programadores que escribe guías, compartimos nuestras experiencias y ayudamos a responder dudas sobre programación."</p>
        <footer class="blockquote-footer">Script Hub Team</footer>
    </blockquote>
@stop

@section('footer_section')
@stop

@section('scripts')
<script>
    var logoRotate = anime({
        targets: '#logo-scripthub',
        translateX: '100%',
        rotate: '2turn',
        scale: 1.5,
        easing: 'easeInOutQuad'
    });
</script>
@endsection
