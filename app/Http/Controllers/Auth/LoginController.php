<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Credential are not valid'], 401);
        }

        $user = auth()->user();

        return response()->json([
            'message' => 'Login Successfully',
            'token' => $user->createToken('apitodos')->plainTextToken
        ]);
    }
}
