<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\BotsRequest;
use App\Http\Requests\ModifyBotRequest;

use App\Bots;
use App\ScriptHubUsers;

class BotsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('verified')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bots = Bots::all()->sortByDesc('popularity');
        return view('bots.index', compact('bots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        return view('bots.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BotsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BotsRequest $request)
    {
        if(empty($request->all())) {
            return redirect()->route('bots.create')
                             ->withErrors([
                                'empty' => '¡El formulario está vacío!',
                             ]);
        }

        // Getting user
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        // Creating bot
        $bot = Bots::make($request->all());

        // Checking for avatar files
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->avatar->storeAs('', 'user' . $bot->id . '_avatar.' . $request->avatar->extension(), 'images');
            $bot->avatar_url = Storage::disk('images')->url($path);
        }

        // Foreign keys aren't mass assigment to avoid falsehood of identity
        $bot->fk_scripthub_users = $user->id;
        $bot->fk_scripthub_users_discord_users = $user->fk_discord_users;
        $bot->save();

        // Redirecting
        $request->flash('Has creado un bot.');
        return redirect()->route('users.bots', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function show(Bots $bot, $bot_id)
    {
        $bot = Bots::findOrFail($bot_id);
        return view('bots.show', compact('bot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bots $bot, $bot_id)
    {
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        $bot = Bots::findOrFail($bot_id);
        if ($bot->scripthub_user != $user) {
            return redirect()->route('users.bots', $user)
                            ->withErrors([
                                'forbidden' => 'No puedes editar los bots de otros usuarios.',
                            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ModifyBotRequest  $request
     * @param  \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function update(ModifyBotRequest $request, Bots $bot, $bot_id)
    {
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        $bot = Bots::findOrFail($bot_id);
        if ($bot->scripthub_user != $user) {
            abort(403, 'Acceso denegado. No puedes editar bots de otros usuarios.');
        }

        $info = $request->all();
        if(empty($info)) {
            return redirect()->route('bots.edit', $bot)
                             ->withErrors([
                                 'empty' => '¡El formulario está vacío!',
                             ]);
        }

        $bot->fill($info);
        $bot->save();

        $request->flash('¡Tu bot se ha actualizado con éxito!');
        return redirect()->route('bots.show', $bot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bots $bot)
    {
        //
    }
}
