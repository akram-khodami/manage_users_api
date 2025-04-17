<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );

        $user->assignRole('user');

        $tokenData = $this->generateToken($user);

        return response()->json(
            [
                'message' => 'User is registerd successfully.',
                'access_token' => $tokenData['token'],
                'token_type' => 'Bearer',
                'expires_at' => $tokenData['expires_at'],
                'user' => $user,
            ], 200
        );

    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json(
                [
                    'message' => 'The provided credentials are incorrect.',
                    'error' => 'Unauthorized'
                ], 401
            );

        }

        $tokenData = $this->generateToken($user);

        return response()->json(
            [
                'message' => 'Logged in successfully.',
                'access_token' => $tokenData['token'],
                'token_type' => 'Bearer',
                'expires_at' => $tokenData['expires_at'],
                'user' => $user,
            ], 201
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'message' => 'Logout successfully.'
            ]
        );
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logged out from all devices'
            ]
        );

    }

    protected function generateToken(User $user): array
    {
        $token = $user->createToken('api-token')->plainTextToken;
        $tokenModel = $user->tokens()->latest()->first();
        $tokenModel->expires_at = now()->addDays(1);
        $tokenModel->save();

        return [
            'token' => $token,
            'expires_at' => $tokenModel->expires_at
        ];
    }
}
