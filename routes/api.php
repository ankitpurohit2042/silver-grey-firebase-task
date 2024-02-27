<?php

use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
return $request->user();
});
Route::middleware('firebase.auth')->get('/protected-route', function (Request $request) {
return response()->json(['message' => 'Authenticated']);
}); */

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource("/firebase", FirebaseController::class);
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers\Api\V1\Auth'], function () {

    Route::group(['prefix' => 'oauth'], function () {

        Route::post('login', "AuthController@login"); /*
    Route::post('register', 'Auth\AuthController@register');
    Route::post('socialLogin', 'Auth\AuthController@socialLogin');
    Route::post('forgotPassword', 'Auth\AuthController@forgotPassword');
    Route::post('resetPassword', 'Auth\AuthController@resetPassword'); */

    });
});
