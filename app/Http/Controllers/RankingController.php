<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Rangliste wird geholt und an View übergeben.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRanking()
    {
        CodeCount::setRank();

        $rankObj = DB::select('SELECT * FROM users WHERE total_points > 0 ORDER BY total_points DESC,rank;');
        $rankArray = json_decode(json_encode($rankObj), true);
        $userRank = count($rankArray);

        return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
    }
}
