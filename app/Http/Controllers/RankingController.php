<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRanking()
    {
        $this->setRank();

        $rankObj = DB::select('SELECT first_name,scoutname,last_name,rank,total_points,start,end FROM users WHERE total_points > 0 ORDER BY rank DESC, total_points DESC;');
        $rankArray = json_decode(json_encode($rankObj), true);
        $userRank = count($rankArray);

        return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
    }

    private function setRank()
    {
        DB::select('SELECT first_name,scoutname,last_name,rank,total_points,start,end FROM users WHERE total_points > 0 ORDER BY rank DESC, total_points DESC;');
    }
}
