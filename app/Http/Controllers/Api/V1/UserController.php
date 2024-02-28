<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\User\UserListingRequest;
use App\Http\Resources\CustomCollection;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use App\Repositories\Api\UserRepository;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $model;
    protected $userRepository;
    protected $auth;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new User());
        $this->auth = app('firebase.auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserListingRequest $request)
    {
        $users = $this->userRepository->getUserlist($request);
        return new CustomCollection($users, 'App\Http\Resources\V1\User\UserResource');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $userData = User::find(decrypt($id));
            if ($userData) {
                return new UserResource($userData);
            }
            return response()->json(setResponse(['message' => __('User Not found.')]))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json(setResponse(['message' => __('User not found.')]))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterRequest $request, string $id)
    {
        try {
            $id = decrypt($id);
            $userData = $this->userRepository->show($id);
            $this->userRepository->update($request->all(), $id);
            $request['displayName'] = $request->name;
            $this->auth->updateUser($userData->uuid, $request->all());
            return response()->json(setResponse(['message' => __('User Detail Updated successfully')]))
                ->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()
                ->json(setErrorResponse($th->getMessage()))
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $id = decrypt($id);
            $userData = $this->userRepository->show($id);
            if ($userData) {
                $this->userRepository->delete($id);
                $this->auth->deleteUser($userData->uuid);
                return response()->json(setResponse(['message' => __('User deleted successfully')]))
                    ->setStatusCode(Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(setResponse(['message' => __('User not found.')]))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }
}
