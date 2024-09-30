<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginUserRequest;
use Illuminate\Database\Console\Migrations\StatusCommand;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'email' => $request->get('email'),
                    'message' => 'Login failed',
                ],
                401
            );
        }

        $user = User::firstWhere('email', $request->email);

        return response()->json(
            [
                'email' => $request->get('email'),
                'message' => 'Login successful',
                'user' => $user,
                'password' => $request->get('password'),
                'token' => $user->createToken('remember_token', $request->email)->plainTextToken,
            ],
            200
        );
    }

    public function register(Request $request)
    {
        return response()->json(
            [
                'email' => $request->get('email'),
                'message' => 'Register successful',
                'password' => $request->get('password'),
            ],
            200
        );
    }
}
