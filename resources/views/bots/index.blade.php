@extends('layouts.main')
@section('title', 'Bots')

@section('main_content')
<div class="container-fluid py-4">
    <ul class="row justify-content-sm-around">
        @foreach ($bots as $bot)
            <li class="col-3 ml-1 mb-4 card py-2">
                <img src="{{ \Faker\Factory::create()->imageUrl }}" alt="" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $bot->name }}</h5>
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
                        ID del Bot: {{ $bot->id }}
                    </li>
                    <li class="list-group-item">
                        Prefijo de servidor: <code>{{ $bot->prefix }}</code>
                    </li>
                    <li class="list-group-item">
                        Dueño: <a href="{{ route('users.show', $bot->scripthub_user) }}" class="link">{{ $bot->scripthub_user->username }}</a>
                    </li>
                    <li class="list-group-item">
                        ID del Dueño: {{ $bot->discord_user->id }}
                    </li>
                </ul>
                <div class="card-footer text-muted">
                    Petición enviada <em class="font-italic">{{ $bot->requested_at->diffForHumans() }}</em>.
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
