<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    private static function index()
    {
        $allUsers = DB::select('SELECT name_gen FROM users;');
        $userArray = json_decode(json_encode($allUsers), true);

        $userCount = count($allUsers);

        foreach ($userArray as $user) {
            $rawRank = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users_codes.fk_game_codes IS NOT NULL AND users.name_gen = ?;', [$user['name_gen']]);
            $rankArray = json_decode(json_encode($rawRank), true);

            print_r($rankArray);
            $rankCount = count($rankArray);

            $points = 0;
            foreach ($user['points'] as $point) {
                $points += $point['points'];
            }

            if ($points > 0) {
                DB::update('UPDATE users SET rank = ? WHERE name_gen = ?;', [$points, $user['name_gen']]);
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRanking()
    {
        self::index();

        $rankObj = DB::select('SELECT first_name,scoutname,last_name,rank  FROM users WHERE rank > 0 ORDER BY rank DESC;');
        $rankArray = json_decode(json_encode($rankObj), true);
        $userRank = count($rankArray);

        return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
    }
}
