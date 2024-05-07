<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    private function sendVerificationCode(User $user):void
    {
        $code = random_int(100000, 999999); // Generate a random verification code

        // Send the email with the user and code
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
        $user->verification_code = $code;
        $user->expiration_code_time = Carbon::now()->addMinutes(10); // expires in 10 minutes
        $user->save();
    }

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
        $email_verified_at = $user->email_verified_at;

        if ($email_verified_at === null) {
            $this->sendVerificationCode($user);
            return response()->json([
                'message' => 'Email not verified, check your email for verification code',
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'user'=> [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ],
            'access_token' => $user->createToken('api_token')->plainTextToken,
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

        $this->sendVerificationCode($user);

        return (new AuthResource($user))->response();
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        Log::info('EDmail: ', [$user->password, $request->password, Hash::check('password', $user->password)]);
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                Rule::notIn([Hash::check($request->password, $user->password)]),
            ],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($user === null) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->password = $validated['password'];
        $user->save();

        return response()->json([
            'message' => 'Password updated',
        ], 200);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user->verification_code === $validated['code'] && $user->expiration_code_time > Carbon::now()) {
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json([
                'message' => 'Email verified',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid verification code',
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();;
        $request->user()->tokens()->delete();
        return (new AuthResource($user))->response();
    }
}
