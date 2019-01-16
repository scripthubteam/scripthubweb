@extends('layouts.main')
@section('title', 'Verificación de Email')

@section('main_content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica tu Email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha reenviado el Email de confirmación.') }}
                        </div>
                    @endif

                    {{ __('Antes de proceder, revisa tu dirección de email para confirmarlo a través de link que se te ha enviado.') }}
                    <br>
                    {{ __('Si no recibiste un email') }}, <a href="{{ route('verification.resend') }}">{{ __('haz click aquí para recibir otro') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
