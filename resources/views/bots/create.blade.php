@extends('layouts.main')
@section('title', 'Crear Bot')

@section('main_section')
    <div class="container-fluid py-4">
        <div class="row">
            {!! Form::open([
                'route' => 'bots.store',
                'class' => 'border border-black rounded p-4'
            ]) !!}
            @csrf
            {!! Form::close() !!}
        </div>
        @include('errors.list')
    </div>
@endsection
