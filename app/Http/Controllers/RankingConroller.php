<?php

namespace App\Http\Controllers;

class RankingConroller extends Controller
{
    public function showRanking()
    {
        return view('leader.ranking');
    }
}
