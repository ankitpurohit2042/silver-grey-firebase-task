<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ChangePasswordRequest;
use App\Http\Requests\Api\V1\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $auth;
    protected $authData;

    public function __construct()
    {
        try {
            $this->auth = app('firebase.auth');
            $this->authData = getCurrentUserDetails();
        } catch (\Throwable $th) {
            return response()
                ->json(setErrorResponse($th->getMessage()))
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request)
    {
        try {
            $data = $request->except('email', 'password');

            User::find($this->authData->id)->update($data);

            /* firebase data update */
            $request['displayName'] = $request->name;

            $this->auth->updateUser($this->authData->uuid, $request->all());
            return response()->json(setResponse(['message' => __('Profile Update Successfully.')]))
                ->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(setResponse(['message' => $th->getMessage()]))
                ->setStatusCode(Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, $this->authData->password)) {
            return response()
                ->json(setErrorResponse(__("Incorrect old password")))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        User::find($this->authData->id)->update(['password' => bcrypt($request->password)]);
        $this->auth->changeUserPassword($this->authData->uuid, $request->password);
        $this->auth->revokeRefreshTokens($this->authData->uuid);
        return response()->json(setResponse(['message' => __('Your password has been changed.')]))
            ->setStatusCode(Response::HTTP_OK);
    }
}
