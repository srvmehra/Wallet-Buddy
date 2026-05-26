<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Make sure to Valid credentials.'
            ], 401);
        }

        $token = $user->createToken('wallet-buddy')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }

    function register() {
        // This Method can be implemented later
    }
}
