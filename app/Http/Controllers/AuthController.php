<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'exists:users,email',
            ],
            'password' => [
                'required',
            ],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Incorrect Email / Password.',
            ], 400);
        }

        return $this->JwtResponse($user);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        $credentials = $request->only(['name', 'email', 'password']);
        $credentials['id'] = Str::uuid();

        $user = User::create($credentials);

        return $this->JwtResponse($user);
    }

    /**
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function JwtResponse($user): \Illuminate\Http\JsonResponse
    {
        $expiresIn = 43200; // 12 Hours

        $payload = [
            'userId' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'exp' => (new DateTime())->getTimestamp() + $expiresIn,
        ];


        $responseWithToken = [
            'access_token' => JWT::encode($payload, env('JWT_SECRET'), env('JWT_ALGO')),
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
            'user' => $user,
        ];

        return response()->json($responseWithToken);
    }
}
