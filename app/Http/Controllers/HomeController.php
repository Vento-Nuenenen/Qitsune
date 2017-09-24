<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;

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
	 * @return \Illuminate\Http\Response
	 */
    public function checkAuth()
    {
	    if(Auth::check() && Voyager::can('browse_admin')){
		    return redirect()->action('RankingController@showRanking');
	    }else if(Auth::check()){
		    return redirect()->action('DescriptionController@showDescription');
	    }
=======

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAuth(Request $request, DescriptionController $ds)
    {
        if (Auth::check() && Voyager::can('browse_admin')) {
            return redirect()->action('RankingController@showRanking');
        } elseif (Auth::check()) {
            return redirect()->action('DescriptionController@showDescription');
        } else {
            $request->session()->flash('error', 'Bitte Log dich ein oder Registrier dich!');

            return redirect()->route('login');
        }
>>>>>>> 4d72e0abb842ab1066be1c196a21f565d32282ec
    }
}
