<?php

namespace App\Http\Controllers;

use App\Bots;
use Illuminate\Http\Request;

class BotsController extends Controller
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
        //
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
     * @param  \App\Bots  $bots
     * @return \Illuminate\Http\Response
     */
    public function show(Bots $bots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bots  $bots
     * @return \Illuminate\Http\Response
     */
    public function edit(Bots $bots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bots  $bots
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bots $bots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bots  $bots
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bots $bots)
    {
        //
    }
}
