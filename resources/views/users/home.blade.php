@extends('layouts.main')

@section('title', 'home')

@section('main_content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->username }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ $user->username}} ({{ $user->discord_user->id }})</h5>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
