<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpCode extends Model
{
    protected $fillable = ['email', 'code', 'expires_at', 'is_used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /**
     * Generate and send OTP to email
     */
    public static function generateFor(string $email): self
    {
        // Invalidate previous OTPs for this email
        self::where('email', $email)->where('is_used', false)->update(['is_used' => true]);

        // Generate 6-digit OTP
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create OTP record (expires in 10 minutes)
        $otp = self::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via email
        Mail::to($email)->send(new OtpMail($code));

        return $otp;
    }

    /**
     * Verify OTP code
     */
    public static function verify(string $email, string $code): bool
    {
        $otp = self::where('email', $email)
            ->where('code', $code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($otp) {
            $otp->update(['is_used' => true]);
            return true;
        }

        return false;
    }

    /**
     * Check if OTP is valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }
}
