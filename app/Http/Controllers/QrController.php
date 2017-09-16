<?php

namespace App\Http\Controllers;

class QrController extends Controller
{
    public function showUser()
    {
        $rawQR = DB::select('SELECT * FROM game_codes WHERE game_code = ?;', [$param]);
        $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);

        if (empty($checkExists)) {
            DB::table('users_codes')->insert(['fk_users' => Auth::user()->id, 'fk_game_codes' => $rawQR[0]->id]);
            $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
        }

        return view('qr', ['checkExists' => $checkExists]);
    }

    public function showAdmin()
    {
    }
}
