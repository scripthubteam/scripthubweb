<?php

namespace App\Http\Controllers;

use App\DiscordUsers;
use Illuminate\Http\Request;

class DiscordUsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discord_users = DiscordUsers::all();
        return view('discord.index', compact('discord_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscordUsers  $discordUser
     * @return \Illuminate\Http\Response
     */
    public function show(DiscordUsers $discordUser, $id)
    {
        $discordUser = DiscordUsers::findOrFail($id);
        return view('discord.show', compact('discordUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscordUsers  $discordUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscordUsers $discordUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscordUsers  $discordUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscordUsers $discordUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscordUsers  $discordUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscordUsers $discordUser)
    {
        //
    }
}
