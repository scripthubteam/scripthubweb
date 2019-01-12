@extends('layout')
@section('title', 'Script Hub Tema - Login')

@section('main_content')
    <div class="container py-4">
        <div class="row align-items-center justify-content-center">
            <h2 class="col-10 text-center">¡Bienvenido a Script Hub!</h2>
        </div>
        <div class="row align-items-center justify-content-center">
            {{ Form::open([
                'url' => '',
                'class' => 'd-flex flex-column align-items-start border border-black rounded p-4'
            ]) }}
            <div class="form-group">
                {{ Form::label('username', 'Usuario') }}
                {{ Form::text('username', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de usuario',
                    'required'
                ]) }}
                <a href="{{ route('users.register') }}" class="link">Registrarse</a>
            </div>
            <div class="form-group">
                {{ Form::label('password', 'Contraseña') }}
                {{ Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña para el Login',
                    'required'
                ]) }}
                <a href="" class="link">Recuperar contraseña</a>
            </div>
            <div class="form-group align-self-center">
                {{ Form::submit('Entrar', ['class' => 'btn btn-info']) }}
                {{ Form::reset('Limpiar', ['class' => 'btn btn-secondary']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
@stop
