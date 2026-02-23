<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UmkmUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'umkm@umkmlokal.id'],
            [
                'name' => 'Pemilik UMKM Demo',
                'email' => 'umkm@umkmlokal.id',
                'password' => Hash::make('password'),
                'role' => UserRole::UMKM,
                'email_verified_at' => now(),
            ]
        );
    }
}
