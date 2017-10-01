<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AJAX extends Controller
{
	public function ranking()
	{
		$allUsers = DB::select('SELECT name_gen FROM users WHERE fk_role = 2;');
		$userArray = json_decode(json_encode($allUsers), true);

		$userCount = count($allUsers);

		for ($i = 0; $i < $userCount; ++$i) {
			$rawRank = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL AND users.name_gen = ?;', [$userArray[$i]['name_gen']]);
			$rankArray = json_decode(json_encode($rawRank), true);

			$rankCount = count($rankArray);

			$points = 0;
			for ($j = 0; $j < $rankCount; ++$j) {
				$points += $rankArray[$j]['points'];
			}

			if ($points > 0) {
				DB::update('UPDATE users SET rank = ? WHERE name_gen = ?;', [$points, $rankArray[$i]['name_gen']]);
			}
		}

		$rankObj = DB::select('SELECT prename,scoutname,surname,rank  FROM users WHERE fk_role = 2 AND rank > 0 ORDER BY rank DESC;');
		$rankArray = json_decode(json_encode($rankObj), true);
		$userRank = count($rankArray);

		return view('home', ['rankArray' => $rankArray, 'userRank' => $userRank])->renderSections()['dynamicRanking'];
	}
}
