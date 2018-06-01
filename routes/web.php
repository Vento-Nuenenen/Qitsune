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
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Auth::routes();

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    // Activation Routes
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{name_gen}/updateUserAccount', [
        'as'   => '{name_gen}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{name_gen}/updateUserPassword', [
        'as'   => '{name_gen}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{name_gen}/deleteUserAccount', [
        'as'   => '{name_gen}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'qr'], function () {
            Route::get('/scan/{uniqKey}', 'ScanController@showScan');
        });

        Route::get('/description', 'DescriptionController@showDescription');
        Route::get('/', 'DescriptionController@showDescription');
    });
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');

    Route::group(['prefix' => 'leader'], function () {
        Route::group(['prefix' => 'qr'], function () {
            Route::get('/generate', 'GenerateController@showGenerate');
            Route::get('/generate/do', 'GenerateController@index');
            Route::get('/download', function () {
                return response()->download(storage_path('pdf/file/QR-Codes.pdf'));
            });
        });

        Route::get('/ranking', 'RankingController@showRanking');
        Route::get('/', 'RankingController@showRanking');
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('php', 'AdminDetailsController@listPHPInfo');
    Route::get('routes', 'AdminDetailsController@listRoutes');

    Route::get('/ajax/ranking', 'AJAX@ranking');
});
