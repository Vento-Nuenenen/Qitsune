<?php

namespace App\Http\Controllers;

use DB;

class AJAX extends Controller
{
    public function ranking()
    {
	    $allUsers = DB::select('SELECT name_gen FROM users;');
	    $userArray = json_decode(json_encode($allUsers), true);

	    $userCount = count($allUsers);

	    for ($i = 1; $i < $userCount; ++$i) {
		    $rawRank = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL AND users.name_gen = ?;', [$userArray[$i - 1]['name_gen']]);
		    $rankArray = json_decode(json_encode($rawRank), true);

		    $rankCount = count($rankArray);

		    $points = 0;
		    for ($j = 1; $j <= $rankCount; ++$j) {
			    $points += $rankArray[$j - 1]['points'];
		    }

		    if ($points > 0) {
			    DB::update('UPDATE users SET total_points = ? WHERE name_gen = ?;', [$points, $rankArray[$i - 1]['name_gen']]);
		    }
	    }


	    $rankObj = DB::select('SELECT first_name,scoutname,last_name,total_points  FROM users WHERE total_points > 0 ORDER BY total_points DESC;');
	    $rankArray = json_decode(json_encode($rankObj), true);
	    $userRank = count($rankArray);

	    return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
    }
}
