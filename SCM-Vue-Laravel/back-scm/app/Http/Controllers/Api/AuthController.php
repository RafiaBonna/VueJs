<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Check credentials
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // 2. Generate token using Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 3. Get user role
        $role = $user->roles->first() ? $user->roles->first()->slug : 'none';

        // 4. Return response with token and role
        return response()->json([
            'token' => $token,
            'user' => [
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $role,
            ],
            'message' => 'Login successful',
        ], 200);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        // Delete current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
