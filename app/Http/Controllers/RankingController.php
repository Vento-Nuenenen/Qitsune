<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function showRanking(){
    	$this->index();

	    $rankObj = DB::select('SELECT first_name,scoutname,last_name,rank  FROM users WHERE total_points > 0 ORDER BY rank DESC;');
	    $rankArray = json_decode(json_encode($rankObj), true);
	    $userRank = count($rankArray);

    	return view('leader.ranking',['rankArray' => $rankArray, 'userRank' => $userRank]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	private static function index()
	{
		$allUsers = DB::select('SELECT name_gen FROM users;');
		$userArray = json_decode(json_encode($allUsers), true);

		$userCount = count($allUsers);

		for ($i = 0; $i < $userCount; $i++) {
			$rawRank = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL AND users.name_gen = ?;', [$userArray[$i]['name_gen']]);
			$rankArray = json_decode(json_encode($rawRank), true);

			$rankCount = count($rankArray);

			$points = 0;
			for ($j = 0; $j < $rankCount; $j++) {
				$points += $rankArray[$j]['points'];
			}

			if ($points > 0) {
				DB::update('UPDATE users SET rank = ? WHERE name_gen = ?;', [$points, $rankArray[$i]['name_gen']]);
			}
		}
	}
}
