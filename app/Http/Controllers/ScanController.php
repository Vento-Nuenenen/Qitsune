<?php

namespace App\Http\Controllers;

use Auth;
use DB;

class ScanController extends Controller
{
    /**
     * Grant scanned code or return issue.
     *
     * @param $param
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showScan($param)
    {
        $rawQR = DB::select('SELECT * FROM game_codes WHERE  game_code = ?', [$param]);
        $checkExists = $this->checkCodeExists($param, Auth::user()->name_gen);

        if (count($rawQR) > 0) {
            if (count($checkExists) < 1) {
                DB::table('users_codes')->insert(['fk_users' => Auth::user()->id, 'fk_game_codes' => $rawQR[0]->id]);
                $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                $checkExists = json_decode(json_encode($checkExists));
                $view = view('user.scan', ['checkExists' => $checkExists]);
            } else {
                $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                $checkExists = json_decode(json_encode($checkExists));
                $view = view('user.scan', ['checkExists' => $checkExists])->withErrors('Der Code wurde bereits gezählt.');
            }

            $this->calcTotalPoints(Auth::user()->name_gen);

            return $view;
        } else {
            abort(404);
        }
    }

    /**
     * Check if scanned code is available in DB.
     *
     * @param $code
     * @param $name_gen
     *
     * @return mixed
     */
    private function checkCodeExists($code, $name_gen)
    {
        return DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [$name_gen, $code]);
    }

    /**
     * Calculate total points of current user.
     *
     * @param $name_gen
     */
    private function calcTotalPoints($name_gen)
    {
        $allPoints = $this->getAllPointsPerUser($name_gen);

        $totalPoints = 0;
        foreach ($allPoints as $point) {
            $totalPoints += $point['points'];
        }

        if ($totalPoints > 0) {
            DB::update('UPDATE users SET total_points = ? WHERE name_gen = ?;', [$totalPoints, $name_gen]);
        }
    }

    /**
     * Get all grantet points of current user.
     *
     * @param $name_gen
     *
     * @return mixed
     */
    private function getAllPointsPerUser($name_gen)
    {
        $pointsPerUser = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users.name_gen = ?;', [$name_gen]);

        return $pointsPerUserArray = json_decode(json_encode($pointsPerUser), true);
    }
}
