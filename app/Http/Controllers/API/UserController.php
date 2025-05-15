<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Controllers\API\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\RateLimiter;
class UserController extends Controller
{
    use ApiResponseTrait;


    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');





        if (!auth()->attempt($credentials)) {
            return $this->ApiResponse(null, __('بيانات الدخول غير صحيحة'), 401);
        }

        $user = auth()->user();

        $token = $user->createToken('auth_token')->plainTextToken;
        RateLimiter::clear('login-attempts:' . $request->ip() . ':' . $request->email);

        return $this->ApiResponse(
            [
                'token' => $token,
                'user' => new UserResource($user),
            ],
            __('تم تسجيل الدخول بنجاح'),

        );
    }


    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);


        $user->assignRole('user');

        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->ApiResponse(
            [
                'token' => $token,
                'user' => new UserResource($user),
            ],
            __('تم تسجيل المستخدم بنجاح'),
        );
    }







    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->ApiResponse(null, __('User logged out successfully'));
    }


    private function RateLimiter($key = null)
    {
        $maxAttempts = 5;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return $this->ApiResponse(
                null,
                __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
                429
            );
        }

        RateLimiter::hit($key, $decaySeconds);
    }
}
