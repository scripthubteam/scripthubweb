@extends('layouts.main')

@section('title', $scriptHubUser->username)

@section('main_content')
<div class="container-fluid py-4">
    <div class="row justify-content-center p-2">
        <div class="jumbotron col-11">
            <div class="container">
                <div class="row align-items-center">
                    <img src="{{ $scriptHubUser->avatar_url }}" alt="Avatar" class="col-12 col-md-5 img-fluid">
                    <div class="col">
                        <h1 class="col display-4">{{ $scriptHubUser->username }}</h1>
                        <p class="lead">
                            (Discord ID: {{ $scriptHubUser->discord_users_id }})
                        </p>
                        <p>
                            @if ($scriptHubUser->description)
                                <i>{{ $scriptHubUser->description }}</i>
                            @endif
                        </p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row align-items-center justify-content-md-end">
                    <a href="" class="col-12 col-md-3 btn btn-primary btn-lg my-2 my-sm-0" role="button">Administrar Bots</a>
                    <a href="{{ route('users.edit', $scriptHubUser) }}" class="col-12 col-md-3 btn btn-secondary btn-lg my-2 my-sm-0 ml-md-2" role="button">Editar Perfil</a>
                    <a id="removeUserBtn" href="{{ route('users.destroy', $scriptHubUser) }}" class="col-12 col-md-3 btn btn-danger btn-lg my-2 my-sm-0 ml-md-2" role="button">Eliminar Perfil</a>
                    {!! Form::open([
                        'route' => ['users.destroy', $scriptHubUser],
                        'method' => 'delete',
                        'class' => 'd-none',
                        'id' => 'user-destroy-form',
                    ]) !!}
                    {!! Form::token() !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script src="{{ url('/').'/js/destroy.js' }}"></script>
@endsection
