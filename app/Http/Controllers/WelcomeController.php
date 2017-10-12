<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Applikations-Dashboard anzeigen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome');
    }
}
