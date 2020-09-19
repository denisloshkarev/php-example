<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if($request->get('phone')) {
            $credentials = [
                'phone' => $this->formatPhone($request->get('phone')),
                'password' => $request->get('password'),
            ];
        }
        else {
            $credentials = $request->only('email', 'password');
        }
        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }

        return response([
            'status' => 'success',
            'token' => $token,
            'roles' => auth()->user()->roles->pluck('name')->toArray()
        ]);
    }
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    public function user(Request $request)
    {
        $user = User::find(auth()->id());
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    private function guard()
    {
        return auth()->guard();
    }

    private function formatPhone($phone)
    {
        return '+'.preg_replace('/\D/', '', $phone);
    }
}
