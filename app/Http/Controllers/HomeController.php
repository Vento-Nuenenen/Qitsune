<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAuth()
    {
        if (Auth::check() && Voyager::can('browse_admin')) {
            return redirect()->action('RankingController@showRanking');
        } elseif (Auth::check()) {
            return redirect()->action('DescriptionController@showDescription');
        }
    }
}
