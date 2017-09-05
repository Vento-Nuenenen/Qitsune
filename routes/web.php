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

Auth::routes();

Route::get('/home', 'RankController@show');

Route::get('/qr', 'GeneratePDF@show');
Route::get('/qr/do', 'GeneratePDF@index');
Route::get('/qr/download', function () {
    return response()->download(storage_path('pdf/generated/QR-Codes.pdf'));
});
Route::get('/qr/{uniqKey}', 'CheckQR@index');

Route::get('/admin', 'AdminController@index');
