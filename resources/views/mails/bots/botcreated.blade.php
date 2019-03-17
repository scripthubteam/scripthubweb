@component('mail::message')
# Introduction

Tu Bot {{ $bot->name }} ha sido creado. Ahora nuestros administradores se pondrán en marcha para tenerlo disponible
en el servidor cuanto antes.

@component('mail::button', ['url' => route('bots.show', $bot), 'color' => 'blue'])
Ver bot
@endcomponent

Muchas gracias,<br>
{{ config('app.name') }}
@endcomponent
