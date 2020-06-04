<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function register(Request $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }
    public function login(Request $request)
    {
        $credentials = null;
        if ($request->has('email')){
            $credentials = request(['email', 'password']);
        }elseif ($request->has('name')){
            $credentials = request(['name', 'password']);
        }

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    
    public function getUserData()
    {
        return response()->json($this->guard()->user());
    }

    public function saveUserData(Request $request)
    {
        $data = $request->all();
        $user = auth('api')->user();
        $user->update($data);
        $user->save();

        return response()->json(['status' => 'success']);

    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        $data['id'] = $user->id;
        $data['user_id'] = $user->user_id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['avatar'] = $user->avatar;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user' => $data
        ]);
    }
    public function guard()
    {
        return Auth::guard();
    }
}
