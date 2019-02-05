@extends('layouts.main')
@section('title', $scriptHubUser->username)

@section('main_content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card card-user-show flex-row my-5">
                <div class="card-img-left d-none d-md-flex">

                </div>
                <div class="card-body">
                    <h4 class="card-title text-center">
                        {{ $scriptHubUser->username }} (Discord ID: {{ $scriptHubUser->fk_discord_users }})
                    </h4>
                    <hr class="my-4">
                    <p class="card-text text-center">
                        {{ $scriptHubUser->description }}
                    </p>
                    <hr class="my-4">
                    <a href="{{ route('users.bots', $scriptHubUser) }}" class="btn btn-primary justify-self-end">Ver Bots</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
