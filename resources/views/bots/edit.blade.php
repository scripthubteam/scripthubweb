@extends('layouts.main')
@section('title', 'Editar ' . $bot->name)

@section('main_content')
<div class="container-fluid py-4">
    <h2 class="font-weight-light text-center">{{ __('Editando ' . $bot->name . ' (' . $bot->id . ')') }}</h2>
    <hr>
    <figure class="row justify-content-center align-items-center">
        <img class="img-fluid rounded-top w-25" src="{{ $bot->avatar_url }}" alt="">
    </figure>
    <div class="row align-items-center justify-content-center my-4">
        {!! Form::model($bot, [
            'route' => ['bots.update', $bot],
            'method' => 'put',
            'class' => 'border border-black rounded p-4',
            'files' => true,
        ]) !!}
        {!! Form::token() !!}
        <div class="form-group">
            {!! Form::label('name', 'Nick del Bot') !!}
            {!! Form::text('name', old('name'), [
                'class' => 'form-control',
            ]) !!}
        </div>
        <div class="from-group">
            {!! Form::label('prefix', 'Prefijo del Bot') !!}
            {!! Form::text('prefix', old('prefix'), [
                'class' => 'form-control',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('info', 'Descripción') !!}
            {!! Form::textarea('info', old('info'), [
                'class' => 'form-control',
                'placeholder' => '¡Descripción de tu Bot y lo que hace!',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('avatar', 'Avatar') !!}
            {!! Form::file('avatar', [
                'class' => 'form-control-file',
            ]) !!}
        </div>
        <div class="w-100"></div>
        <div class="form-group">
            {!! Form::submit('Actualizar', [
                'class' => 'btn btn-primary',
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
