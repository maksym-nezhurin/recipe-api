<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\EmailNotVerifiedResource;
use App\Http\Resources\LoginAuthResource;
use App\Http\Resources\LoginInvalidResource;
use App\Http\Resources\RegisterAuthResource;
use App\Mail\VerificationCodeMail;
use App\Models\User;
//
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Send a verification email to the user
     * @param User $user
     * $return void
     */
    public function sendVerificationMail(User $user)
    {
        Log::info('Sending verification email to ' . $user->email);
        $code = random_int(100000, 999999); // Generate a random verification code

        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
        $user->verification_code = $code;
//        $user->verification_code_expires_at = Carbon::now()->addMinutes(10); // expires in 10 minutes
        $user->save();
    }

    /**
     * @param LoginAuthRequest $request
     * @return LoginAuthResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginAuthRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return (new LoginInvalidResource(null))->response()->setStatusCode(401);
        }

        $user = User::where('email', $validated['email'])->first();

        if(!$user->email_verified_at) {
            $this->sendVerificationMail($user);

            return (new EmailNotVerifiedResource(null))->response()->setStatusCode(401);
        }

        return new LoginAuthResource($user);
    }

    /**
     * @param RegisterAuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterAuthRequest $request) {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $this->sendVerificationMail($user);

        return (new RegisterAuthResource($user))->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = auth()->user();;
        $request->user()->tokens()->delete();
        return (new AuthResource($user))->response()->setStatusCode(200);
    }
}
