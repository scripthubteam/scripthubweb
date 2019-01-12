<?php

namespace App\Http\Controllers;

use App\ScriptHubUsers;
use App\TempRegistration;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('password') == $request->get('repeat_password')) {
            $tmp_registration = TempRegistration::where('discord_users_id', $request->get('discord_id'))->get()->first();
            if ($tmp_registration) {
                if ($tmp_registration->hash_code == $request->get('token')) {
                    ScriptHubUsers::create([
                        'username' => $request->get('username'),
                        'email' => $request->get('email'),
                        'password' => $request->get('password'),
                        'discord_users_id' => $request->get('discord_id')
                    ]);
                    $tmp_registration->delete();
                    return redirect('login');
                } else {
                    dd("Error en el Hash");
                }
            } else {
                dd("No existe usuario Discord");
            }
        } else {
            dd("Las contraseñas no son iguales");
        }


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
