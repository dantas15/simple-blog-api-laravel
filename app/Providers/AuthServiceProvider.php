<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('custom-jwt', function ($request) {
            $token = $request->bearerToken();

            if ($token && strlen($token) > 0) {
                try {
                    $payload = JWT::decode($token, new Key(env('JWT_SECRET'), env('JWT_ALGO')));
                } catch (\Throwable $e) {
                    return null;
                }

                return User::find($payload->userId);
            }

            return null;
        });
    }
}
