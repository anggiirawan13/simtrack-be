<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {
    public function login(Request $request) 
    {
        $credentials = $request->only('username', 'password');

        // Cek apakah username ada
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return new ApiResource([
                'status' => false,
                'message' => 'Username does not exist.',
                'resource' => null,
            ], 404);
        }

        try {
            if ($user->password !== $credentials['password']) {
                return new ApiResource([
                    'status' => false,
                    'message' => 'Invalid password.',
                    'resource' => null,
                ], 401);
            }
        } catch (\Exception $e) {
            return new ApiResource([
                'status' => false,
                'message' => 'An error occurred while decrypting the password.',
                'resource' => null,
            ], 500);
        }

        Log::info($user);
        // Login berhasil
        return new ApiResource([
            'status' => true,
            'message' => 'Login successful!',
            'resource' => $user,
        ]);
    }
}

