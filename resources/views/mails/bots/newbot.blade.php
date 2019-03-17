@component('mail::message')
# Introduction

El usuario {{ $bot->scripthub_user->username }} <i>(Discord ID: {{ $bot->fk_scripthub_users_discord_users }})</i> ha creado un bot.

@component('mail::button', ['url' => '/', 'color' => 'blue'])
Invitar Bot al Servidor
@endcomponent

@component('mail::panel')
<b>Nombre:</b> {{ $bot->name }}<br>
<b>ID:</b> {{ $bot->id }}<br>
<b>Prefijo:</b> {{ $bot->prefix }}<br>
<b>ID del Dueño:</b> {{ $bot->fk_scripthub_users_discord_users }}
@endcomponent

Fecha de petición <b>{{ \Carbon\Carbon::now() }}</b>.<br>

Recuerda comunicar a todo el equipo si has invitado al Bot al servidor.<br>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
