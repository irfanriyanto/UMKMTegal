<?php

namespace App\Livewire\Contact;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';
    public bool $submitted = false;

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'email' => 'required|email|max:100',
        'subject' => 'required|min:5|max:200',
        'message' => 'required|min:10|max:2000',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'subject.required' => 'Subjek wajib diisi.',
        'message.required' => 'Pesan wajib diisi.',
        'message.min' => 'Pesan minimal 10 karakter.',
    ];

    public function submit()
    {
        $this->validate();

        // Check contact form rate limit (3 submissions per 10 minutes)
        $rateLimitKey = 'contact-form:' . request()->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            $this->dispatch('toast', type: 'error', message: "Terlalu banyak pesan terkirim. Silakan coba lagi dalam {$minutes} menit.");
            return;
        }

        // Hit rate limiter
        RateLimiter::hit($rateLimitKey, 600); // 10 minutes = 600 seconds

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->submitted = true;
        $this->reset(['name', 'email', 'subject', 'message']);
        $this->dispatch('toast', type: 'success', message: 'Pesan Anda berhasil dikirim. Terima kasih!');
    }

    public function render()
    {
        return view('livewire.contact.contact-form');
    }
}
