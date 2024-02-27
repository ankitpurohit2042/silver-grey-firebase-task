<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        dd("sd");
        // Find the user by email
        $user = $this->user->where(['email' => $request->email, 'status' => 'Active'])->first();
        if ($user) {
            // Verify the password and generate the token
            if (Hash::check($request->get('password'), $user->password)) {
                return $this->createLoginToken($user, $request);
            } else {
                return response()
                    ->json(setErrorResponse(__('Invalid credentials')))
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            }
        } else {
            return response()
                ->json(setErrorResponse(__('Please verify email to login')))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

    }
}
