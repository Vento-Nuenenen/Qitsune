<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class CheckQR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($param)
    {
	    $rawQR = DB::select('SELECT * FROM game_codes WHERE game_code = ?;',array($param));
	    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;',array(Auth::user()->name_gen,$param));

	    if(empty($checkExists)){
		    DB::table('users_codes')->insert(['fk_users' => Auth::user()->id,'fk_game_codes' => $rawQR[0]->id]);
		    $checkExists = DB::select('SELECT * FROM users RIGHT JOIN users_codes ON users.id = users_codes.fk_users RIGHT JOIN game_codes ON users_codes.fk_game_codes = game_codes.id WHERE name_gen = ? AND game_code = ?;',array(Auth::user()->name_gen,$param));
	    }

	    return view('qr',['checkExists' => $checkExists]);
    }
}
