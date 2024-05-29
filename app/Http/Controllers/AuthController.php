<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Requests\VerifyAuthRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\CodeUnverifiedResource;
use App\Http\Resources\CodeVerifiedResource;
use App\Http\Resources\EmailNotVerifiedResource;
use App\Http\Resources\LoginAuthResource;
use App\Http\Resources\LoginInvalidResource;
use App\Http\Resources\RegisterAuthResource;
use App\Http\Resources\UpdatePasswordResource;
use App\Mail\VerificationCodeMail;
use App\Models\User;
// use Carbon\Carbon;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Send a verification email to the user
     * @param User $user
     * $return void
     */
    public function sendVerificationMail(User $user)
    {
        $code = random_int(100000, 999999); // Generate a random verification code
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
        } catch (Error $error) {
            Log::error('Error sending verification email: ' . $error->getMessage());
        }
        $user->verification_code = $code;
        $user->expiration_code_time = Carbon::now()->addMinutes(10); // expires in 10 minutes
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

    public function updatePassword(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
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

        return (new UpdatePasswordResource($user))->response()->setStatusCode(200);
    }

    public function verify(VerifyAuthRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if ($user->verification_code === $validated['code']) {
            if ($user->expiration_code_time > Carbon::now()) {
                return response()->json([
                    'message' => 'Verification code expired',
                    'verified' => false
                ], 401);
            }
            $user->email_verified_at = Carbon::now();
            $user->save();
            return (new CodeVerifiedResource($user))->response()->setStatusCode(200);
        }

        return (new CodeUnverifiedResource($user))->response()->setStatusCode(401);
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
