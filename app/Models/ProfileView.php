<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileView extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_profile_id',
        'ip_address',
        'viewed_date',
    ];

    protected function casts(): array
    {
        return [
            'viewed_date' => 'date',
        ];
    }

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class);
    }

    public static function recordView(int $profileId, string $ipAddress): void
    {
        static::firstOrCreate([
            'umkm_profile_id' => $profileId,
            'ip_address' => $ipAddress,
            'viewed_date' => now()->toDateString(),
        ]);
    }
}
