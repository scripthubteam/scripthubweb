<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\BotsRequest;
use App\Http\Requests\ModifyBotRequest;

use App\Bots;
use App\ScriptHubUsers;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewBotCreated;
use App\Notifications\BotCreated;

class BotsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('verified')->except(['index']);
        $this->middleware('admin')->only(['accept', 'deny']);
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
            $path = $request->avatar->storeAs('', 'bot' . $bot->id . '_avatar.' . $request->avatar->extension(), 'images');
            $bot->avatar_url = Storage::disk('images')->url($path);
        }

        // Foreign keys aren't mass assigment to avoid falsehood of identity
        $bot->fk_scripthub_users = $user->id;
        $bot->fk_scripthub_users_discord_users = $user->fk_discord_users;
        $bot->save();

        // Notificating admins
        $admins = ScriptHubUsers::where('is_admin', true)->get();
        Notification::send($admins, new NewBotCreated($bot));

        // Notification user
        $user->notify(new BotCreated($bot));

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
        return view('bots.edit', compact('bot'));
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

        if($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->avatar->storeAs('', 'bots' . $bot->id . '_avatar.' . $request->avatar->extension(), 'images');
            $bot->avatar_url = Storage::disk('images')->url($path);
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
    public function destroy(Bots $bot, $bot_id)
    {
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        $bot = Bots::findOrFail($bot_id);
        if ($bot->scripthub_user != $user) {
            abort(403, 'Acceso denegado. No puedes borrar bots de otros usuarios.');
        }

        // Deletes bot
        $bot->delete();

        return redirect()->route('users.bots', $user)->with('status', 'Bot eliminado');
    }

    /**
     * Validates a bot.
     *
     * @param \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function accept(Bots $bot, $bot_id)
    {
        $bot = Bots::findOrFail($bot_id);
        $bot->validated = true;
        $bot->save();

        return redirect()->route('bots.show', $bot)->with('status', 'Bot validado.');
    }

    /**
     * Denies a bot.
     *
     * @param \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function deny(Bots $bot, $bot_id)
    {
        // Since we deny a bot, this will be erased.
        $bot = Bots::findOrFail($bot_id);
        $bot->delete();

        return redirect()->route('bots.index')->with('status', 'Bot denegado.');
    }
}
