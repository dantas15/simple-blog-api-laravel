<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login']);
    }

    public function login(Request $request)
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

//        dd([ 'credentials' => bcrypt($credentials['password']), 'pass' => $user->password, 'same' => $user->password == bcrypt($credentials['password'])]);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Incorrect Email / Password.',
            ], 400);
        }

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
        ];

        return response()->json($responseWithToken);
    }
}
