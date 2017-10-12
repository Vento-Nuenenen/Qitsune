<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CodeCount;

class RankingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRanking()
    {
        $this->setRank();

        $rankObj = DB::select('SELECT * FROM users WHERE total_points > 0 ORDER BY total_points DESC,rank;');
        $rankArray = json_decode(json_encode($rankObj), true);
        $userRank = count($rankArray);

        return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
    }

    private function setRank()
    {
    	$totalPoints = CodeCount::getTotalPoints();
	    $rankObj = DB::select('SELECT * FROM users WHERE total_points = '.$totalPoints.' ORDER BY TIMEDIFF(start, end) DESC;');

	    for($i = 0; $i < count($rankObj); $i++){
			DB::table('users')->where('name_gen', $rankObj[$i]->name_gen)->update(['rank' => (++$i)]);
			$i--;
	    }
    }
}
