<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Login rate limiter: 5 attempts per minute by IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
                    ], 429, $headers);
                });
        });

        // OTP request rate limiter: 3 requests per 5 minutes by email
        RateLimiter::for('otp-request', function (Request $request) {
            $key = $request->input('email', $request->ip());
            return Limit::perMinutes(5, 3)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak permintaan OTP. Silakan coba lagi dalam 5 menit.',
                    ], 429, $headers);
                });
        });

        // OTP verify rate limiter: 5 attempts per 10 minutes by email
        RateLimiter::for('otp-verify', function (Request $request) {
            $key = $request->input('email', $request->ip());
            return Limit::perMinutes(10, 5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan verifikasi. Silakan coba lagi dalam 10 menit.',
                    ], 429, $headers);
                });
        });

        // Contact form rate limiter: 3 submissions per 10 minutes by IP
        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinutes(10, 3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak pesan terkirim. Silakan coba lagi dalam 10 menit.',
                    ], 429, $headers);
                });
        });

        // API rate limiter: 60/min for guests, 120/min for authenticated users
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(120)->by($request->user()->id)
                : Limit::perMinute(60)->by($request->ip());
        });
    }
}
