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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ScriptHubUsers $scriptHubUsers, $id)
    {
        $scriptHubUsers = ScriptHubUsers::findOrFail($id);
        dd($scriptHubUsers);
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
