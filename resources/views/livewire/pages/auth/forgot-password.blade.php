<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-craft-800 text-center mb-6">Lupa Kata Sandi</h2>
    
    <div class="mb-4 text-sm text-craft-600">
        Lupa kata sandi? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" class="text-craft-700" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-craft-300 focus:border-craft-500 focus:ring-craft-500 rounded-lg" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-craft-600 hover:bg-craft-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" wire:loading.attr="disabled">
                <svg wire:loading wire:target="sendPasswordResetLink" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="sendPasswordResetLink">Kirim Link Reset Kata Sandi</span>
                <span wire:loading wire:target="sendPasswordResetLink">Mengirim...</span>
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a class="text-sm text-craft-600 hover:text-craft-800" href="{{ route('login') }}">
                Kembali ke halaman <span class="font-semibold">Masuk</span>
            </a>
        </div>
    </form>
</div>
