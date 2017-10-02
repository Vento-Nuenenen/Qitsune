<?php

namespace App\Http\Controllers;

use Auth;
use DB;

class ScanController extends Controller
{
    public function showScan($param)
    {
        $rawQR = DB::select('SELECT * FROM game_codes WHERE  game_code = ?', [$param]);
        $checkExists = $this->checkCodeExists($param, Auth::user()->name_gen);

        if (count($rawQR) > 0) {
            if (count($checkExists) < 1) {
                DB::table('users_codes')->insert(['fk_users' => Auth::user()->id, 'fk_game_codes' => $rawQR[0]->id]);
                $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                $checkExists = json_decode(json_encode($checkExists));

                return view('user.scan', ['checkExists' => $checkExists]);
            } else {
                $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
                $checkExists = json_decode(json_encode($checkExists));

                return view('user.scan', ['checkExists' => $checkExists])->withErrors('Der Code wurde bereits gezählt.');
            }
        } else {
            abort(404);
        }
    }

    private function checkCodeExists($code, $name_gen)
    {
        return DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [$name_gen, $code]);
    }

    private function calcTotalPoints()
    {
    }
}
