@extends('layouts.main')
@section('title', 'Crear Bot')

@section('main_content')
    <div class="container-fluid py-4">
        <h2 class="font-weight-light text-center">{{ __("¡Añade tu Bot hoy mismo!") }}</h2>
        <hr>
        <div class="row align-items-center justify-content-center my-4">
            {!! Form::open([
                'route' => 'bots.store',
                'class' => 'border border-black rounded p-4'
            ]) !!}
            {!! Form::token() !!}
            <div class="form-group">
                {!! Form::label('name', 'Nombre del Bot') !!}
                {!! Form::text('name', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre para el Bot',
                    'required',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('prefix', 'Prefijo') !!}
                {!! Form::text('prefix', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Prefijo para el Bot',
                    'required',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('info', 'Descripción') !!}
                {!! Form::textarea('info', '', [
                    'class' => 'form-control',
                    'placeholder' => '¡Descripción de tu Bot y lo que hace!',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Crear', [
                    'class' => 'btn btn-info',
                ]) !!}
                {!! Form::reset('Limpiar', [
                    'class' => 'btn btn-secondary',
                ]) !!}
            </div>
            {!! Form::close() !!}
            <div class="w-100 my-2"></div>
            <a href="{{ route('users.bots', Auth::user()->id) }}" class="link">Volver</a>
        </div>
        @include('errors.list')
    </div>
@endsection
