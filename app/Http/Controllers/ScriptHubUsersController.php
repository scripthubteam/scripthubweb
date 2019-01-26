<?php

namespace App\Http\Controllers;

use App\ScriptHubUsers;
use App\TempRegistration;
use App\Http\Requests\ScriptHubUsersRequest;
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
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        return view('users.home', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ScriptHubUsers $scriptHubUser, $user)
    {
        return view('users.show', compact('scriptHubUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(ScriptHubUsers $scriptHubUser, $user)
    {
        $scriptHubUser = ScriptHubUsers::findOrFail($user);
        if(\Auth::user()->id != $scriptHubUser->id) {
            abort(403, 'Acceso denegado. No puedes editar otro usuarios.');
        }

        return view('users.edit', compact('scriptHubUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function update(ScriptHubUsersRequest $request, ScriptHubUsers $scriptHubUser, $user)
    {
        // Checks if ID belongs to user
        $scriptHubUser = ScriptHubUsers::findOrFail($user);
        // Checks if logged user is User to edit
        if(\Auth::user()->id != $scriptHubUser->id) {
            abort(403, 'Acceso denegado. No puedes editar a otros usuarios.');
        }

        // Overwrites User to Edit
        $scriptHubUser = \Auth::user();
        $input = [];

        // Checking password and description are in input
        if($request->input('username') != $scriptHubUser->username) {
            $input['username'] = $request->input('username');
        }
        if($request->input('email') != $scriptHubUser->email) {
            $input['email'] = $request->input('email');
        }
        if($request->has('password')) {
            $input['password'] = $request->input('password');
        }
        if($request->has('description')) {
            $input['description'] = $request->input('description');
        }

        // Updating
        $scriptHubUser->fill($input);
        $scriptHubUser->save();

        // Redirecting
        $request->flash('Has actualizado tu perfil con éxito.');
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScriptHubUsers $scriptHubUsers, $user)
    {
        //
    }
}
