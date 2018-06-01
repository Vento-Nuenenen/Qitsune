<?php
	/**
	 * Created by PhpStorm.
	 * User: caspa
	 * Date: 31.05.2018
	 * Time: 13:16
	 */

	namespace App\Http\Controllers;


	use Illuminate\Support\Facades\DB;

	class RankingController extends Controller
	{
		public function showRanking(){
			CodeCount::setRank();

			$rankObj = DB::select('SELECT * FROM users WHERE total_points > 0 ORDER BY total_points DESC,rank;');
			$rankArray = json_decode(json_encode($rankObj),true);
			$userRank = count($rankArray);

			return view('leader.ranking', ['rankArray' => $rankArray, 'userRank' => $userRank]);
		}
	}