<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {
    public function login(Request $request) 
    {
        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return new ApiResource([
                'status' => false,
                'message' => 'Username atau password salah.',
                'resource' => null,
            ], 404);
        }

        try {
            if ($user->password !== $credentials['password']) {
                return new ApiResource([
                    'status' => false,
                    'message' => 'Username atau password salah.',
                    'resource' => null,
                ], 401);
            }
        } catch (Exception $e) {
            return new ApiResource([
                'status' => false,
                'message' => 'Terjadi kesalahan pada sistem.',
                'resource' => null,
            ], 500);
        }

        Log::info($user);
        return new ApiResource([
            'status' => true,
            'message' => 'Login berhasil.',
            'resource' => $user,
        ]);
    }
}

