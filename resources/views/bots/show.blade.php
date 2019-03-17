@extends('layouts.main')
@section('title', $bot->name)

@section('main_content')
<div class="container-fluid py-4">
    <div class="row justify-content-center p-2">
        <div class="jumbotron col-11">
            <div class="container">
                <div class="row align-items-center">
                    <img src="{{ $bot->avatar_url }}" alt="Avatar" class="col-12 col-md-5 img-fluid">
                    <div class="col">
                        <h1 class="col display-4">
                            {{ $bot->name }}
                        </h1>
                        <p class="lead">
                            (Puntuación: {{ $bot->popularity }})
                            @if ($bot->validated)
                                <div class="alert-success text-center" role="alert">Validado</div>
                            @else
                                <div class="alert-warning text-center" role="alert">En espera</div>
                            @endif
                        </p>
                        <p>
                            @if ($bot->info)
                                <i>{{ $bot->info }}</i>
                            @endif
                        </p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row align-items-center justify-content-md-end">
                    <a href="{{ route('users.show', $bot->scripthub_user) }}" class="col-12 col-md-3 btn btn-primary btn-lg my-2 my-sm-0" role="button">Ver Dueño</a>
                    @if (Auth::user()->id == $bot->fk_scripthub_users)
                        <a href="{{ route('bots.edit', $bot) }}" class="col-12 col-md-3 btn btn-secondary btn-lg my-2 my-sm-0 ml-md-2" role="button">Editar</a>
                        <a id="removeBotBtn" href="{{ route('bots.destroy', $bot) }}" class="col-12 col-md-3 btn btn-danger btn-lg my-2 my-sm-0 ml-md-2" role="button">Eliminar</a>
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
                @if (Auth::user()->is_admin && !$bot->validated)
                    <hr class="my-4">
                    <div class="row align-items-center justify-content-md-end">
                        <div class="w-100 my-1"></div>
                        <a href="{{ route('bots.validate', $bot) }}" class="col-12 col-md-3 btn btn-success btn-lg my-2 my-sm-0 ml-md-2">Aceptar</a>
                        <a href="{{ route('bots.deny', $bot) }}" class="col-12 col-md-3 btn btn-warning btn-lg my-2 my-sm-0 ml-md-2" role="button">Denegar</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script src="{{ url('/') . '/js/destroy_bot.js' }}"></script>
@endsection
