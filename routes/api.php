<?php

use Illuminate\Support\Facades\Route;

define("PROFILE", "/profile");
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1\\'], function () {

    Route::group(['prefix' => 'oauth'], function () {

        Route::post('login', "Auth\AuthController@login");
        Route::post('register', 'Auth\AuthController@register');
    });
    Route::group(['middleware' => ['firebaseAuth']], function () {
        Route::resource("/users", 'UserController');
        Route::resource(PROFILE, 'ProfileController')->except(["update", "edit", "delete"]);
        Route::put(PROFILE . "/change-password", 'ProfileController@changePassword');
        Route::put(PROFILE, 'ProfileController@update');
        Route::patch(PROFILE, 'ProfileController@update');
    });
});
