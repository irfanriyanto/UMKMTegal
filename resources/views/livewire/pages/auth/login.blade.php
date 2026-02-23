<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirect berdasarkan role
        $user = Auth::user();
        if ($user->isAdmin()) {
            $this->redirect(route('admin.dashboard', absolute: false));
        } elseif ($user->isUmkm()) {
            $this->redirect(route('umkm.dashboard', absolute: false));
        } else {
            $this->redirect(route('home', absolute: false));
        }
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-craft-800 text-center mb-6">Masuk ke Akun</h2>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" class="text-craft-700" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" value="Kata Sandi" class="text-craft-700" />
            <div class="relative mt-1">
                <input wire:model="form.password" id="password" 
                    class="block w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg pr-10"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required autocomplete="current-password" />
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
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-craft-300 text-craft-600 shadow-sm focus:ring-craft-500" name="remember">
                <span class="ms-2 text-sm text-craft-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-craft-600 hover:bg-craft-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" wire:loading.attr="disabled">
                <svg wire:loading wire:target="login" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">Memproses...</span>
            </button>
        </div>
        
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-craft-600 hover:text-craft-800" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
            
            <a class="text-sm text-craft-600 hover:text-craft-800" href="{{ route('register') }}">
                Belum punya akun? <span class="font-semibold">Daftar</span>
            </a>
        </div>
    </form>
</div>
