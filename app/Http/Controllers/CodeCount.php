<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CodeCount extends Controller
{
    /**
     * Anzahl codes in DB hinterlegen.
     *
     * @param $codeCount
     *
     * @return int
     */
    public static function setCodeCount($codeCount)
    {
        DB::table('game_admin')->insert(['code_count' => $codeCount, 'total_points' => $codeCount]);

        return intval($codeCount);
    }

    /**
     * Anzahl codes aus DB holen und ausgeben.
     *
     * @return mixed
     */
    public static function getCodeCount()
    {
        $codeCount = DB::table('game_admin')->select('code_count')->first()->code_count;

        return $codeCount;
    }

    /**
     * Anzahl codes aus DB holen und ausgeben.
     *
     * @return mixed
     */
    public static function getTotalPoints()
    {
        $totalPoints = DB::table('game_admin')->select('total_points')->first();

        if($totalPoints){
	        return $totalPoints->total_points;
        }else{
        	return 0;
        }
    }

    public static function setRank()
    {
        $totalPoints = self::getTotalPoints();
        $rankObj = DB::select('SELECT * FROM users WHERE total_points = '.$totalPoints.' ORDER BY TIMEDIFF(start, end) DESC;');

        for ($i = 0; $i < count($rankObj); $i++) {
            DB::table('users')->where('name_gen', $rankObj[$i]->name_gen)->update(['rank' => (++$i)]);
            $i--;
        }
    }
}
