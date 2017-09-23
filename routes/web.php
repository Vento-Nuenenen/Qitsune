<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@checkAuth')->name('home');

Route::group(['prefix' => 'leader'], function () {
	Route::group(['prefix' => 'qr'], function () {
		Route::get('/generate','GenerateController@showGenerate');
	});

	Route::get('/ranking','RankingController@showRanking');
});

Route::group(['prefix' => 'user'], function () {
	Route::group(['prefix' => 'qr'], function () {
		Route::get('/scan','ScanController@showScan');
	});

	Route::get('/description','DescriptionController@showDescription');
});
