<?php

namespace App\Http\Controllers;

use App\ScriptHubUsers;
use App\TempRegistration;
use App\Http\Requests\CreateScripthubUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ScriptHubUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateScripthubUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScripthubUserRequest $request)
    {
        ScriptHubUsers::create($request->all());
        TempRegistration::deleteById($request->get('discord_users_id'));
        return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ScriptHubUsers $scriptHubUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(ScriptHubUsers $scriptHubUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScriptHubUsers $scriptHubUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScriptHubUsers $scriptHubUsers)
    {
        //
    }
}
