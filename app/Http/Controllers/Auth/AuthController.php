<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validate([
                'full_name' => ['required', 'string', 'max:255'],
                // 'phone_number' => ['required', 'string', 'max:255', 'unique:users'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                // 'status' => ['required', 'string', 'max:255'],
            ]);

            $user = User::create([
                'full_name' => $data['full_name'],
                // 'phone_number' => $data['phone_number'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                // 'status' => $data['status'],
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            $cookies = cookie('token', $token, 60 * 24);

            return response()->json([
                'user' => new UserResource($user),

            ])->withCookie($cookies);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Username/Email or password is incorrect!',
                'error' => $th->getMessage()
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['login'])
            ->orWhere('username', $data['login'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Username/Email or password is incorrect!'
            ], 401);
        }

        // $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        $cookies = cookie('token', $token, 60 * 24);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ])->withCookie($cookies);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $cookie = cookie()->forget('token');

        return response()->json(['message' => 'Logged out successfully'])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }
}
