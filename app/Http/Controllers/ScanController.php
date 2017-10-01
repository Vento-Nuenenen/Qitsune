<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function showScan($param){
	    if (Auth::check()) {
		    $rawQR = DB::select('SELECT * FROM game_codes WHERE game_code = ?;', [$param]);
		    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);

		    if (empty($checkExists)) {
			    DB::table('users_codes')->insert(['fk_users' => Auth::user()->id, 'fk_game_codes' => $rawQR[0]->id]);
			    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;', [Auth::user()->name_gen, $param]);
		    }

		    return view('qr', ['checkExists' => $checkExists]);
	    } else {
		    return redirect()->route('login');
	    }

        return view('user.scan');
    }
}
