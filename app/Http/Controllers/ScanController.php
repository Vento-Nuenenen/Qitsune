<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class ScanController extends Controller
    {
	    /**
	     * @param $param
	     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	     */
	    public function showScan($param)
        {
            $rawQR = DB::select('SELECT * FROM game_codes WHERE  game_code = ?', [$param]);
            $checkExists = $this->checkCodeExists($param, Auth::user()->name_gen);
            $maxPoints = CodeCount::getTotalPoints();

            if (count($rawQR) > 0) {
                if (count($checkExists) < 1) {
                    DB::table('users_codes')->insert(['fk_users' => Auth::user()->id, 'fk_game_codes' => $rawQR[0]->id]);
                    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                    $checkExists = json_decode(json_encode($checkExists));
                    $view = view('user.scan', ['checkExists' => $checkExists, 'maxPoints' => $maxPoints, 'first' => 1]);
                } else {
                    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                    $checkExists = json_decode(json_encode($checkExists));
                    $view = view('user.scan', ['checkExists' => $checkExists, 'maxPoints' => $maxPoints])->withErrors('Der Code wurde bereits gezählt.');
                }

                $this->calcTotalPoints(Auth::user()->name_gen);

                return $view;
            } else {
                abort(404);
            }
        }

	    /**
	     * @param $code
	     * @param $name_gen
	     * @return array
	     */
	    private function checkCodeExists($code,$name_gen)
        {
            return DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [$name_gen, $code]);
        }

	    /**
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

            if (count($allPoints) == 1) {
                DB::table('users')->where('id', Auth::User()->id)->limit(1)->update(['start' => Carbon::now()->toDateTimeString()]);
            }

            $codeCount = $this->getCodeCount();

            if (count($allPoints) == $codeCount) {
                DB::table('users')->where('id', Auth::User()->id)->update(['end' => Carbon::now()->toDateTimeString()]);
            }
        }

	    /**
	     * @param $name_gen
	     * @return mixed
	     */
	    private function getAllPointsPerUser($name_gen)
        {
            $pointsPerUser = DB::select('SELECT points,name_gen FROM users LEFT JOIN users_codes ON users.id = users_codes.fk_users LEFT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE users.name_gen = ?;', [$name_gen]);

            return $pointsPerUserArray = json_decode(json_encode($pointsPerUser), true);
        }
    }
