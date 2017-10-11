<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodeCount extends Controller
{
	/**
	 * Anzahl codes in DB hinterlegen.
	 *
	 * @param $codeCount
	 *
	 * @return int
	 */
	public static function setCodeCount($codeCount)
	{
		DB::table('game_admin')->insert(['code_count' => $codeCount]);

		return intval($codeCount);
	}

	public static function getCodeCount(){
		$codeCount = DB::table('game_admin')->select('code_count')->first()->code_count;

		return $codeCount;
	}
}
