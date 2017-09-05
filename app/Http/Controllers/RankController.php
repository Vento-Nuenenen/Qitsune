<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private static function index()
    {
	    $allUsers = DB::select('SELECT name_gen FROM users WHERE fk_role = 2;');
	    $userArray = json_decode(json_encode($allUsers), true);

	    $userCount = count($allUsers);

	    for($i = 0; $i < $userCount; ++$i){
		    $rawRank = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL AND users.name_gen = ?;',array($userArray[$i]['name_gen']));
		    $rankArray = json_decode(json_encode($rawRank), true);

		    $rankCount = count($rankArray);

		    $points = 0;
		    for($j = 0; $j < $rankCount;++$j){
		    	$points += $rankArray[$j]['points'];
		    }

		    DB::update('UPDATE users SET rank = ? WHERE name_gen = ?;',array($points,$rankArray[$i]['name_gen']));
	    }


    }

    public static function show(){
    	RankController::index();

    	$rankObj = DB::select('SELECT prename,scoutname,surname,rank  FROM users WHERE fk_role = 2 ORDER BY rank DESC;');
	    $rankArray = json_decode(json_encode($rankObj), true);
	    $userRank = count($rankArray);

	    return view('home',['rankArray' => $rankArray,'userRank' => $userRank]);
    }
}
