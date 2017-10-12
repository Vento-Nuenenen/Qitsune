<?php

namespace App\Http\Controllers;

use DB;

class AJAX extends Controller
{
    public function ranking()
    {
        CodeCount::setRank();

        $rankObj = DB::select('SELECT * FROM users WHERE total_points > 0 ORDER BY total_points DESC,rank;');
        $rankArray = json_decode(json_encode($rankObj), true);
        $userRank = count($rankArray);

        return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank])->renderSections()['dynamicRanking'];
    }
}
