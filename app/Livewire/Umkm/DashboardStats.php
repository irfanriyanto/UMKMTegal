<?php

namespace App\Livewire\Umkm;

use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        $user = auth()->user();
        $profile = $user->umkmProfile;
        
        $stats = [
            'has_profile' => $profile !== null,
            'is_verified' => $profile?->is_verified ?? false,
            'total_products' => $profile?->products()->count() ?? 0,
            'active_products' => $profile?->products()->where('is_available', true)->count() ?? 0,
            'inactive_products' => $profile?->products()->where('is_available', false)->count() ?? 0,
        ];

        return view('livewire.umkm.dashboard-stats', [
            'stats' => $stats,
            'profile' => $profile,
        ]);
    }
}
