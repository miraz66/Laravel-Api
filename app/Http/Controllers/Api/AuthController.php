<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses; // Ensure this is at the top of your class
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Using the trait globally within the controller
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        // Validate the incoming request data
        $request->validated($request->all());

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        // Retrieve the authenticated user by email
        $user = User::firstWhere('email', $request->email);

        // Return a successful response with user information
        return $this->ok(
            'Authenticated',
            ['token' => $user->createToken(
                'Api token for ' . $request->email,
                Abilities::getAbilities($user),
                now()->addMonths(12)
            )->plainTextToken]
        );
    }

    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        // Return a success response
        return $this->ok('Logged out successfully');
    }
}
