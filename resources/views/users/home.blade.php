@extends('layouts.main')

@section('title', 'home')

@section('main_content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="jumbotron">
            <div class="container">
                <div class="row align-items-center">
                    <img src="{{ \Faker\Factory::create()->imageUrl }}" alt="Avatar" class="col-12 col-md-5 img-fluid">
                    <div class="col">
                        <h1 class="col display-4">{{ $user->username }}</h1>
                        <p class="lead">
                            (Discord ID: {{ $user->discord_users_id }})
                        </p>
                        <p>
                            @if ($user->description)
                                <i>{{ $user->description }}</i>
                            @endif
                        </p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row align-items-center justify-content-md-end">
                    <a href="{{ route('bots.index') }}" class="col-12 col-md-2 btn btn-primary btn-lg my-2 my-sm-0" role="button">Administrar Bots</a>
                    <a href="{{ route('users.edit', $user) }}" class="col-12 col-md-2 btn btn-secondary btn-lg my-2 my-sm-0 ml-md-2" role="button">Editar Perfil</a>
                    <a href="{{ route('users.destroy', $user) }}" class="col-12 col-md-2 btn btn-danger btn-lg my-2 my-sm-0 ml-md-2" role="button">Eliminar Perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
