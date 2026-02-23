<?php

use App\Enums\UserRole;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $otp = '';
    
    public bool $showOtpForm = false;
    public bool $otpSent = false;
    public int $resendCooldown = 0;

    /**
     * Step 1: Validate form and send OTP
     */
    public function sendOtp(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email:rfc,dns', // Validasi email lebih ketat dengan DNS check
                'max:255', 
                'unique:'.User::class
            ],
            'password' => [
                'required', 
                'string', 
                'confirmed', 
                'min:8',
                'regex:/[a-z]/',      // Minimal 1 huruf kecil
                'regex:/[A-Z]/',      // Minimal 1 huruf besar
                'regex:/[0-9]/',      // Minimal 1 angka
            ],
        ], [
            'email.email' => 'Format email tidak valid atau domain email tidak ditemukan.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
        ]);

        // Check OTP request rate limit (3 requests per 5 minutes)
        $rateLimitKey = 'otp-request:' . $this->email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $this->addError('email', "Terlalu banyak permintaan OTP. Silakan coba lagi dalam {$seconds} detik.");
            return;
        }

        try {
            // Hit rate limiter
            RateLimiter::hit($rateLimitKey, 300); // 5 minutes = 300 seconds
            
            // Generate and send OTP
            OtpCode::generateFor($this->email);
            
            $this->showOtpForm = true;
            $this->otpSent = true;
            $this->resendCooldown = 60;
            
            $this->dispatch('toast', type: 'success', message: 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            $this->addError('email', 'Gagal mengirim OTP. Pastikan email valid dan coba lagi.');
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(): void
    {
        if ($this->resendCooldown > 0) {
            return;
        }

        // Check OTP request rate limit
        $rateLimitKey = 'otp-request:' . $this->email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $this->dispatch('toast', type: 'error', message: "Terlalu banyak permintaan OTP. Coba lagi dalam {$seconds} detik.");
            return;
        }

        try {
            RateLimiter::hit($rateLimitKey, 300);
            OtpCode::generateFor($this->email);
            $this->resendCooldown = 60;
            $this->dispatch('toast', type: 'success', message: 'Kode OTP baru telah dikirim.');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Gagal mengirim ulang OTP.');
        }
    }

    /**
     * Step 2: Verify OTP and complete registration
     */
    public function verifyAndRegister(): void
    {
        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
        ]);

        // Check OTP verify rate limit (5 attempts per 10 minutes)
        $rateLimitKey = 'otp-verify:' . $this->email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $this->addError('otp', "Terlalu banyak percobaan verifikasi. Silakan coba lagi dalam {$seconds} detik.");
            return;
        }

        // Hit rate limiter
        RateLimiter::hit($rateLimitKey, 600); // 10 minutes = 600 seconds

        // Verify OTP
        if (!OtpCode::verify($this->email, $this->otp)) {
            $this->addError('otp', 'Kode OTP tidak valid atau sudah kadaluarsa.');
            return;
        }

        // Clear rate limiters on successful verification
        RateLimiter::clear('otp-request:' . $this->email);
        RateLimiter::clear('otp-verify:' . $this->email);

        // Create user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => UserRole::UMKM,
            'email_verified_at' => now(), // Mark as verified since OTP was confirmed
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->dispatch('toast', type: 'success', message: 'Pendaftaran berhasil! Selamat datang di UMKMPedia.');

        $this->redirect(route('umkm.dashboard', absolute: false));
    }

    /**
     * Go back to registration form
     */
    public function backToForm(): void
    {
        $this->showOtpForm = false;
        $this->otp = '';
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-craft-800 text-center mb-2">Daftar Sebagai Pemilik UMKM</h2>
    <p class="text-center text-craft-600 text-sm mb-6">Daftarkan usaha Anda dan mulai promosikan produk ke ribuan pengunjung</p>
    
    @if(!$showOtpForm)
        {{-- Registration Form --}}
        <form wire:submit="sendOtp">
            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" class="text-craft-700" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" value="Email" class="text-craft-700" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg" type="email" name="email" required autocomplete="username" placeholder="contoh@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <p class="text-xs text-craft-500 mt-1">Gunakan email aktif untuk menerima kode verifikasi</p>
            </div>

            <!-- Password -->
            <div class="mt-4" x-data="{ showPassword: false }">
                <x-input-label for="password" value="Kata Sandi" class="text-craft-700" />
                <div class="relative mt-1">
                    <input wire:model="password" id="password" 
                        class="block w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg pr-10"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required autocomplete="new-password" />
                    <button type="button" @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-craft-500 hover:text-craft-700">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-craft-500 mt-1">Minimal 8 karakter kombinasi huruf besar, huruf kecil dan angka</p>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4" x-data="{ showPassword: false }">
                <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="text-craft-700" />
                <div class="relative mt-1">
                    <input wire:model="password_confirmation" id="password_confirmation" 
                        class="block w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg pr-10"
                        :type="showPassword ? 'text' : 'password'"
                        name="password_confirmation" required autocomplete="new-password" />
                    <button type="button" @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-craft-500 hover:text-craft-700">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-craft-600 hover:bg-craft-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="sendOtp" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="sendOtp">Kirim Kode Verifikasi</span>
                    <span wire:loading wire:target="sendOtp">Mengirim...</span>
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a class="text-sm text-craft-600 hover:text-craft-800" href="{{ route('login') }}">
                    Sudah punya akun? <span class="font-semibold">Masuk</span>
                </a>
            </div>
        </form>
    @else
        {{-- OTP Verification Form --}}
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-craft-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <p class="text-craft-600 text-sm">Kode verifikasi telah dikirim ke:</p>
            <p class="font-semibold text-craft-800">{{ $email }}</p>
        </div>

        <form wire:submit="verifyAndRegister">
            <div>
                <x-input-label for="otp" value="Kode OTP (6 digit)" class="text-craft-700 text-center" />
                <x-text-input 
                    wire:model="otp" 
                    id="otp" 
                    class="block mt-2 w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg text-center text-2xl tracking-widest font-mono" 
                    type="text" 
                    maxlength="6" 
                    autocomplete="one-time-code"
                    inputmode="numeric"
                    pattern="[0-9]*"
                />
                <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center" />
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-craft-600 hover:bg-craft-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="verifyAndRegister" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="verifyAndRegister">Verifikasi & Daftar</span>
                    <span wire:loading wire:target="verifyAndRegister">Memverifikasi...</span>
                </button>
            </div>

            <div class="mt-4 text-center" x-data="{ cooldown: @entangle('resendCooldown') }" x-init="
                setInterval(() => {
                    if (cooldown > 0) cooldown--;
                }, 1000)
            ">
                <template x-if="cooldown > 0">
                    <p class="text-sm text-craft-500">
                        Kirim ulang dalam <span class="font-semibold" x-text="cooldown"></span> detik
                    </p>
                </template>
                <template x-if="cooldown <= 0">
                    <button type="button" wire:click="resendOtp" class="text-sm text-craft-600 hover:text-craft-800 font-semibold">
                        Kirim Ulang Kode OTP
                    </button>
                </template>
            </div>

            <div class="mt-4 text-center">
                <button type="button" wire:click="backToForm" class="text-sm text-craft-500 hover:text-craft-700">
                    ← Kembali ke form pendaftaran
                </button>
            </div>
        </form>
    @endif
</div>
