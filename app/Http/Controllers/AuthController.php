<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(ApiLoginRequest $request)
    {
        return response()->json(
            [
                'email' => $request->get('email'),
                'message' => 'Login successful',
                'password' => $request->get('password'),
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
