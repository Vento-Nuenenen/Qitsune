<?php

namespace App\Http\Controllers;

use DB;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
    {
        $users = DB::table('users')->get();

        return view('users.users', ['users' => $users]);
    }

    public function create(){
		return view('users.add');
    }

    public function store(Request $request){
		$scout_name = $request->input('scout_name');
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');

		$password = $request->input('password');
		$password_repeat = $request->input('password_repeat');

		if($password === $password_repeat){
			$password = Hash::make($password);
			$password_repeat = null;

			DB::table('users')->insert(['scout_name' => $scout_name,'first_name' => $first_name,'last_name' => $last_name,'password' => $password]);

			return redirect()->back()->with('message', 'Benutzer wurde erstellt');
		}else{
			return redirect()->back()->with('error', 'Passwort wurde nicht korrekt wiederholt!');
		}
    }


}
