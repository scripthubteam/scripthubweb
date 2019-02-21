@extends('layouts.main')
@section('title', 'Editar')

@section('main_content')
<div class="container py-4">
    <div class="row">
        <h2 class="font-weight-light">Editando {{ $scriptHubUser->username }}</h2>
    </div>
    {!! Form::model($scriptHubUser, [
        'route' => ['users.update', $scriptHubUser],
        'method' => 'put',
        'class' => 'row align-items-start justify-content-end border border-black rounded p-4',
        'files' => true
    ]) !!}
    {!! Form::token() !!}
    <div class="col-5 form-group">
        {!! Form::label('username', 'Nombre de Usuario') !!}
        {!! Form::text('username', old('username'), [
            'class' => 'form-control',
            'placeholder' => 'Nombre de Usuario',
            'required',
        ]) !!}
    </div>
    <div class="col-5 form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', old('email'), [
            'class' => 'form-control',
            'placeholder' => 'Email',
            'required',
        ]) !!}
    </div>
    <div class="col-5 form-group">
        {!! Form::label('password', 'Contraseña') !!}
        {!! Form::password('password', [
            'class' => 'form-control',
        ]) !!}
    </div>
    <div class="col-5 form-group">
        {!! Form::label('repeat_password', 'Repetir Contraseña') !!}
        {!! Form::password('repeat_password', [
            'class' => 'form-control',
        ]) !!}
    </div>
    <div class="col-10 form-group">
        {!! Form::label('description', 'Descripción') !!}
        {!! Form::textarea('description', old('description'), [
            'class' => 'form-control',
        ]) !!}
    </div>
    <div class="w-100"></div>
    <div class="col-6 form-group">
        {!! Form::label('avatar', 'Avatar') !!}
        {!! Form::file('avatar', [
            'class' => 'form-control-file'
        ]) !!}
    </div>
    <div class="w-100"></div>
    <div class="form-group">
        {!! Form::submit('Actualizar', [
            'class' => 'btn btn-discord',
        ]) !!}
        {!! Form::reset('Limpiar', [
            'class' => 'btn btn-secondary',
        ]) !!}
    </div>
    {!! Form::close() !!}
    <div class="row justify-content-end">
        <a href="{{ route('home') }}" class="col-10 link text-right mt-2">Volver</a>
    </div>
    @include('errors.list')
</div>
@endsection
