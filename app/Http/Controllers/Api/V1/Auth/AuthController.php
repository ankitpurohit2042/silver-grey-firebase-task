<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Repositories\Api\UserRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class AuthController extends Controller
{
    private $model;
    protected $auth;

    public function __construct(User $model, FirebaseAuth $auth)
    {
        $this->user = $model;
        $this->model = new UserRepository($model);
        $this->auth = $auth;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()
                ->json(setErrorResponse(__('Invalid Login email and password')))
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        $auth = app("firebase.auth");
        $signInResult = $auth->signInWithEmailAndPassword(
            $request["email"],
            $request["password"]
        );
        return response()->json(['token' => $signInResult->data()['idToken']]);
    }

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {

        try {
            $password = $request['password'];
            $request['password'] = bcrypt($request['password']);
            $request['uuid'] = "";
            $request['remember_token'] = bcrypt($request['password']);

            $userData = $this->model->create($request->all()); //create accountant
            $request['password'] = $password;
            $request['displayName'] = $request->name;
            $data = $this->auth->createUser($request->all());
            $this->model->update([
                "uuid" => $data->uid,
            ], $userData->id);
            return response()
                ->json(setResponse(['message' => __('User register successfully')]))
                ->setStatusCode(Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => __($e->getMessage()), 'alert-type' => 'error']);
        }
    }
}
