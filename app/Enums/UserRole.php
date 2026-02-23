<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case UMKM = 'umkm';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::UMKM => 'Pemilik UMKM',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isUmkm(): bool
    {
        return $this === self::UMKM;
    }
}
