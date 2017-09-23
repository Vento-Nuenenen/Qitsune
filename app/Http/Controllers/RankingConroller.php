<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankingConroller extends Controller
{
    public function showRanking(){
    	return view('leader.ranking');
    }
}
