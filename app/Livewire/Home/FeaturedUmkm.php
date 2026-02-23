<?php

namespace App\Livewire\Home;

use App\Models\UmkmProfile;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class FeaturedUmkm extends Component
{
    public function render()
    {
        $umkmList = Cache::remember('umkm.featured.6', 1800, function () {
            return UmkmProfile::query()
                ->with(['photos', 'products']) // Eager loading
                ->where('is_verified', true)
                ->withCount('profileViews')
                ->orderByDesc('profile_views_count')
                ->limit(6)
                ->get();
        });

        return view('livewire.home.featured-umkm', [
            'umkmList' => $umkmList,
        ]);
    }
}
