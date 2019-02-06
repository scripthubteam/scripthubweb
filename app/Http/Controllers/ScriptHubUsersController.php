<?php

namespace App\Http\Controllers;

use Auth;

use App\Http\Requests\ScriptHubUsersRequest;
use App\ScriptHubUsers;
use App\Bots;

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
        $scriptHubUser = ScriptHubUsers::findOrFail(Auth::user()->id);
        return view('users.home', compact('scriptHubUser'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ScriptHubUsers $scriptHubUser, $user)
    {
        $scriptHubUser = ScriptHubUsers::findOrFail($user);
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
        // Gets both current user and user to edit
        $currentUser = ScriptHubUsers::findOrFail(Auth::user()->id);
        $scriptHubUser = ScriptHubUsers::findOrFail($user);

        // Checks if current user is user to edit.
        if($currentUser != $scriptHubUser) {
            abort(403, 'Acceso denegado. No puedes editar otro usuarios.');
        }

        return view('users.edit', compact('scriptHubUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ScriptHubUsersRequest  $request
     * @param  \App\ScriptHubUsers  $scriptHubUsers
     * @return \Illuminate\Http\Response
     */
    public function update(ScriptHubUsersRequest $request, ScriptHubUsers $scriptHubUser, $user)
    {
        // Gets both current user and user to edit
        $currentUser = ScriptHubUsers::findOrFail(Auth::user()->id);
        $scriptHubUser = ScriptHubUsers::findOrFail($user);

        // Checks if logged user is User to edit
        if($currentUser != $scriptHubUser) {
            abort(403, 'Acceso denegado. No puedes editar a otros usuarios.');
        }

        $info = $request->all();

        // Checks if request is empty
        if (empty($info)) {
            return redirect()->route('users.edit', $user)
                             ->withErrors([
                                 'empty' => '¡El formulario está vacío!'
                             ]);
        }

        // Updating
        $scriptHubUser->fill($info);
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
        // Gets both current user and user to edit
        $currentUser = ScriptHubUsers::findOrFail(Auth::user()->id);
        $scriptHubUser = ScriptHubUsers::findOrFail($user);

        // Checks if current user is user to edit.
        if($currentUser != $scriptHubUser) {
            abort(403, 'Acceso denegado. No puedes borrar a otros usuarios.');
        }

        // Deleting user
        $scriptHubUser->delete();

        // Log out
        Auth::logout();

        // Redirect
        return redirect()->route('root')->with('status', 'Usuario eliminado.');
    }

    /**
     * Show user's bots.
     *
     * @param \App\ScriptHubUsers $scriptHubUser
     * @return \Illuminate\Http\Response
     */
    public function bots(ScriptHubUsers $scriptHubUser, $user) {
        $scriptHubUser = ScriptHubUsers::findOrFail($user);
        $bots = $scriptHubUser->bots->sortByDesc('popularity');
        return view('bots.index')->with([
            'bots' => $bots,
            'user' => $scriptHubUser,
        ]);
    }
}
