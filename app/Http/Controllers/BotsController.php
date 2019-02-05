<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Bots;
use App\ScriptHubUsers;
use Auth;

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
        $user = ScriptHubUsers::findOrFail(Auth::user()->id);
        $bots = Bots::where('fk_scripthub_users', $user->id)->get();
        return view('bots.index', compact('bots', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        return view('bots.create', compact('user'));
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
        $bot = Bots::findOrFail($bot_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bots  $bot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bots $bot)
    {
        //
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
