@extends('layouts.main')
@section('title', 'Usuarios de Discord')

@section('main_content')
    <div class="container-fluid py-4">
        <h2 class="text-center">Lista de Usuarios de Discord Registrados</h2>
        <hr/>
        <h4 class="text-right">Páginas</h3>
        {{ $discord_users->links('layouts.pagination') }}
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nick</th>
                    <th>Discord ID</th>
                    <th>En Discord desde</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discord_users as $discord_user)
                    <tr>
                        <td>
                            <a href="{{ action('DiscordUsersController@show', [$discord_user->id]) }}" class="link text-white">
                                {{ $discord_user->nick }}
                            </a>
                        </td>
                        <td>{{ $discord_user->id }}</td>
                        <td>{{ $discord_user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $discord_users->links('layouts.pagination') }}
    </div>
@stop
