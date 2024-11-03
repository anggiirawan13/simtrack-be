<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Retrieve the validated input data
        $credentials = $request->only('username', 'password');

        // Check if the username exists
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return new ApiResource([
                'status' => false,
                'message' => 'Username does not exist.',
                'resource' => null,
            ], 404);
        }

        // Check if the password matches
        if (!password_verify($credentials['password'], $user->password)) {
            return new ApiResource([
                'status' => false,
                'message' => 'Invalid password.',
                'resource' => null,
            ], 401);
        }

        // Here you can generate a token or handle successful login
        return new ApiResource([
            'status' => true,
            'message' => 'Login successful!',
            'resource' => $user,
        ]);
    }
}
