<?php

<<<<<<< HEAD
=======

>>>>>>> fd930b6d1b0828fd3371a8ae67e1f189ab314e01
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

Route::get('/home', function () {
<<<<<<< HEAD
		return view('home');
});

Route::get('/qr', function () {
	return view('admin.qr');
=======
    return view('user.home');
});

Route::get('/qr', function () {
    return view('user.qr');
>>>>>>> fd930b6d1b0828fd3371a8ae67e1f189ab314e01
});
