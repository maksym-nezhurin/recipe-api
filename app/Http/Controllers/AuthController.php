<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Login information invalid',
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'user'=> [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ],
            'access_token' => $user->createToken('api_token')->plainTextToken,
//            'token_type' => 'Bearer',
        ]);
    }

    /*
     * Register a new user
     */
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return (new AuthResource($user))->response();

//        return response()->json([
//            'data' => $user,
//            'access_token' => $user->createToken('api_token')->plainTextToken,
//            'token_type' => 'Bearer',
//        ],201);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();;
        $request->user()->tokens()->delete();
        return (new AuthResource($user))->response();
//        return (new AuthResource(['status' => "success"]))->response();

//        return response()->json('Successfully logged out');
    }
}
