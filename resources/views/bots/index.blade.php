@extends('layouts.main')
@section('title', 'Bots')

@section('main_content')
<div class="container-fluid py-4">
    <ul class="row justify-content-sm-around">
        @if ($bots->isEmpty())
            {{-- Checks if this is User's index for bots --}}
            @if (isset($user))
                @if ($user->id == Auth::user()->id)
                    <h2 class="">
                        Parece que no tienes ningún bot registrado...<br>
                        <small class="font-weight-light text-muted">¡Puedes añadir uno en menos de 5 minutos!</small>
                    </h2>
                    <div class="w-100 my-4"></div>
                    <a href="{{ route('bots.create') }}" class="btn btn-info col-6 py-3">Añadir un Bot</a>
                @else
                    <h2 class="font-weight-light">
                        Este usuario no tiene ningún bot registrado...
                    </h2>
                @endif
            @else
                <h2 class="">
                    Por ahora no tenemos ningún bot registrado...<br>
                    <small class="font-weight-light text-muted">¡Se el primero en añadir!</small>
                </h2>
                <div class="w-100 my-4"></div>
                <a href="{{ route('bots.create') }}" class="btn btn-info col-6 py-3">Añadir un Bot</a>
            @endif
        @else
            @if (isset($user))
                @if ($user->id == Auth::user()->id)
                    <h2 class="font-weight-light">
                        ¡Tus Bots!
                    </h2>
                @else
                    <h2 class="font-weight-light">
                        ¡Bots de {{ $user->username }}!
                    </h2>
                @endif
            @else
                <h2 class="font-weight-light">
                    ¡Los Bots de nuestro servidor!
                </h2>
            @endif
            <div class="w-100 my-4"></div>
            @foreach ($bots as $bot)
                <li class="col-3 ml-1 mb-4 card py-2">
                    <img src="{{ $bot->discord_user->avatar_url }}" alt="Imagen de Perfil del bot" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $bot->name }} (👍 {{ $bot->popularity }})</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Estado:
                        </h6>
                        @if ($bot->validated)
                            <div class="alert-success text-center" role="alert">Validado</div>
                        @else
                            <div class="alert-warning text-center" role="alert">En espera</div>
                        @endif
                    </div>
                    <div class="card-header">
                        Información
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            ID del Bot: {{ $bot->discord_user->id }}
                        </li>
                        <li class="list-group-item">
                            Prefijo de servidor: <code>{{ $bot->prefix }}</code>
                        </li>
                        <li class="list-group-item">
                            Dueño: <a href="{{ route('users.show', $bot->scripthub_user) }}" class="link">{{ $bot->scripthub_user->username }}</a>
                        </li>
                        <li class="list-group-item">
                            ID del Dueño: {{ $bot->scripthub_user->fk_discord_users }}
                        </li>
                    </ul>
                    <div class="card-footer text-muted">
                        Petición enviada <em class="font-italic">{{ $bot->requested_at->diffForHumans() }}</em>.
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <a href="{{ route('bots.show', $bot) }}" class="col-10 btn btn-primary">Información</a>
                            @if (isset($user) && Auth::user()->id == $bot->fk_scripthub_users)
                                <div class="w-100 my-1"></div>
                                <a href="{{ route('bots.edit', $bot) }}" class="col-10 btn btn-secondary">Editar</a>
                                <div class="w-100 my-1"></div>
                            <a id="removeBotBtn" href="{{ route('bots.destroy', $bot) }}" class="col-10 btn btn-danger">Eliminar</a>
                            {!! Form::open([
                                'route' => ['bots.destroy', $bot],
                                'method' => 'delete',
                                'class' => 'd-none',
                                'id' => 'bot-destroy-form',
                            ]) !!}
                            {!! Form::token() !!}
                            {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
@stop
@section('scripts')
@endsection
