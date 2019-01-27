@extends('layouts.main')
@section('title', 'Login')

@section('main_content')
    <div class="container py-4">
        <div class="row align-items-center justify-content-center">
            <h2 class="col-10 text-center">{{ __("¡Bienvenido a Script Hub!") }}</h2>
        </div>
        <div class="row align-items-center justify-content-center">
            {!! Form::open([
                'route' => 'login',
                'class' => 'd-flex flex-column align-items-start border border-black rounded p-4'
            ]) !!}
            {!! Form::token() !!}
            <div class="form-group">
                {!! Form::label('username', 'Usuario') !!}
                {!! Form::text('username', old('username'), [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de usuario',
                    'required',
                    'autofocus'
                ]) !!}
                <a href="{{ route('register') }}" class="link">{{ __('Registrarme') }}</a>
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña') !!}
                {!! Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña para el Login',
                    'required'
                ]) !!}
                <a href="{{ route('password.request') }}" class="link">{{ __('Recuperar contraseña') }}</a>
            </div>
            <div class="form-group form-check">
                {!! Form::checkbox('remember', '', false, [
                    'class' => 'form-check-input',
                    'id' => 'remember'
                ]) !!}
                {!! Form::label('remember', 'Recordarme', [
                    'class' => 'form-check-label'
                ]) !!}
            </div>
            <div class="form-group align-self-center">
                {!! Form::submit('Entrar', ['class' => 'btn btn-info']) !!}
                {!! Form::reset('Limpiar', ['class' => 'btn btn-secondary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        @include('errors.list')
    </div>
@stop
