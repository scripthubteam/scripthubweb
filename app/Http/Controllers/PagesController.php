<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Redirects to index.
     */
    public function index() {
        return view('pages.welcome');
    }

    /**
     * Redirects to Login.
     */
    public function login() {
        return view('users.login');
    }
}