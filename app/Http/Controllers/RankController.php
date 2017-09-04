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
    public static function index()
    {
        $rawRank = DB::select('SELECT prename,scoutname,surname,points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL;');

        print_r($rawRank);

        foreach ($rawRank as $user => $points) {
            $getPoints = array_search();
        }

        return view('home');
    }
}
