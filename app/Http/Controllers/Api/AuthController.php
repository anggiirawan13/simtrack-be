<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
                'data' => null,
            ], 404);
        }

        try {
            if ($user->password !== $credentials['password']) {
                return new ApiResource([
                    'status' => false,
                    'message' => 'Invalid password.',
                    'data' => null,
                ], 401);
            }
        } catch (\Exception $e) {
            return new ApiResource([
                'status' => false,
                'message' => 'An error occurred while decrypting the password.',
                'data' => null,
            ], 500);
        }

        // Login berhasil
        return new ApiResource([
            'status' => true,
            'message' => 'Login successful!',
            'data' => $user,
        ]);
    }
}

