<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAuth(Request $request,DescriptionController $ds)
    {
	    if(Auth::check() && Voyager::can('browse_admin')){
		    return redirect()->action('RankingController@showRanking');
	    }elseif(Auth::check()){
		    return redirect()->action('DescriptionController@showDescription');
	    }else{
		    $request->session()->flash('error', 'Bitte Log dich ein oder Registrier dich!');

		    return redirect()->route('login');
	    }
    }
}
