<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt.auth')->group(function(){

    // ...

    Route::prefix('admin')->namespace('Admin')->middleware(['role:root'])->group(function () {

        // ...

        Route::post('users/import', 'Import\ImportUsersController');

        // ...

    });

    Route::prefix('v1')->group(function () {

        // ...

        Route::get('themes', 'ThemeController@index');
        Route::get('themes/{theme}', 'ThemeController@show');

        Route::get('profile', 'ProfileController@show');
        Route::put('profile', 'ProfileController@update');
        Route::post('profile/password', 'ProfileController@updatePassword');

        // ...

    });

});
