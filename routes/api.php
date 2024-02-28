<?php

// use App\Http\Controllers\Api\Vi\UserController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1\\'], function () {

    Route::group(['prefix' => 'oauth'], function () {

        Route::post('login', "Auth\AuthController@login");
        Route::post('register', 'Auth\AuthController@register');
        Route::post('verify-token', 'Auth\AuthController@verifyFirebaseToken');
        /* Route::post('forgotPassword', 'Auth\AuthController@forgotPassword');
    Route::post('resetPassword', 'Auth\AuthController@resetPassword'); */

    });
    Route::group(['middleware' => ['firebaseAuth']], function () {
        Route::resource("/users", 'UserController');
    });
});
Route::post('/checktoken', function (Request $request) {
    try {
        $response = (object) [];
        $token = $request->bearerToken();
        $response->token = $token;
        $auth = app('firebase.auth');
        $verifiedIdToken = $auth->verifyIdToken($token);
        if (!$verifiedIdToken) {
            // Handle the case where token verification failed
            // Log an error or return an error response
            return response()->json(['error' => 'Token verification failed'], 401);
        }

        if ($verifiedIdToken) {
            return true;
        }
        dd("Fd");
        $auth = app('firebase.auth');
        // Verify the Firebase ID token
        $verifiedIdToken = $auth->verifyIdToken($token);

        // Access the claims if the token verification was successful
        $claims = $verifiedIdToken->claims();
        dd($claims);
        dd($verifiedIdToken);
        /* check token payload */
        $email = $verifiedIdToken->claims()->get('email');
        $response->payload_email = $email;
        $uid = $verifiedIdToken->claims()->get('sub');
        $response->payload_uid = $uid;

        /* check authenticated user */
        $user = $auth->getUser($uid);
        $response->authenticated_user = $user;

        return response()->json($response, 200);
    } catch (\IdTokenVerificationFailed $e) {
        dd("f");
        echo 'The token is invalid: ' . $e->getMessage();
    }
    dd("d");

});
