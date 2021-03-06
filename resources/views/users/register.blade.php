@extends('layouts.main')

@section('title', 'Registro')

@section('main_content')
    <div class="container py-4">
        <h2 class="font-weight-light text-center">{{ __("¡Únete a Script Hub Team!") }}</h2>
        <hr>
        <div class="row align-items-center justify-content-center my-4">
            {!! Form::open([
                'route' => 'register',
                'class' => 'col-11 col-sm-6 d-flex flex-column align-items-start border border-black rounded p-4'
            ]) !!}
            {!! Form::token() !!}
            <div class="form-group row">
                {!! Form::label('username', 'Nombre de Usuario') !!}
                {!! Form::text('username', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Usuario',
                    'value' => 'old("username")',
                    'required',
                ]) !!}
            </div>
            <div class="form-group row">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', '', [
                    'class' => 'form-control',
                    'placeholder' => 'example@scripthub.com',
                    'value' => 'old("email")',
                    'required',
                ]) !!}
            </div>
            <div class="form-group row">
                {!! Form::label('password', 'Contraseña') !!}
                {!! Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => 'La contraseña a usar',
                    'required',
                ]) !!}
            </div>
            <div class="form-group row">
                {!! Form::label('repeat_password', 'Repetir contraseña') !!}
                {!! Form::password('repeat_password', [
                    'class' => 'form-control',
                    'placeholder' => 'Repita la contraseña',
                    'aria-describedby' => 'passwordHelp',
                    'required',
                ]) !!}
                <small id="passwordHelp" class="d-none form-text text-danger">{{ __("Las contraseñas no son iguales") }}</small>
            </div>
            <div class="form-group row">
                {!! Form::label('fk_discord_users', 'Discord ID') !!}
                {!! Form::text('fk_discord_users', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Tu ID de Discord',
                    'aria-describedby' => 'discordIdHelp',
                    'value' => 'old("fk_discord_users")',
                    'required',
                ]) !!}
                <small id="discordIdHelp" class="form-text text-muted">{{ __("El Bot debería indicártelo.") }}</small>
            </div>
            <div class="form-group row">
                {!! Form::label('hash_code', 'Token') !!}
                {!! Form::password('hash_code', [
                    'class' => 'form-control',
                    'placeholder' => 'Código secreto',
                    'aria-describedby' => 'tokenHelp',
                    'required',
                ]) !!}
                <small id="tokenHelp" class="form-text text-muted">{{ __("Hash secreto generado por el Bot.") }}</small>
            </div>
            <div class="form-group align-self-center">
                {!! Form::submit('Enviar', [
                    'class' => 'btn btn-info'
                ]) !!}
                {!! Form::reset('Limpiar', [
                    'class' => 'btn btn-secondary'
                ]) !!}
            </div>
            {!! Form::close() !!}
            <a href="{{ route('login') }}" class="col-10 link text-center mt-2">Volver</a>
        </div>
        @include('errors.list')
    </div>
@stop

@section('scripts')
<script src="{{ url('/').'/js/register.js' }}"></script>
@stop
