<?php

namespace App\Livewire\Umkm;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Statistics extends Component
{
    public function render()
    {
        $profile = auth()->user()->umkmProfile;
        
        if (!$profile) {
            return view('livewire.umkm.statistics', [
                'hasProfile' => false,
                'stats' => [],
                'topProducts' => collect(),
                'recentViews' => collect(),
            ]);
        }

        // Get stats
        $stats = [
            'total_profile_views' => $profile->profileViews()->count(),
            'profile_views_month' => $profile->profileViews()->where('created_at', '>=', now()->subMonth())->count(),
            'total_product_views' => $profile->products()->withCount('productViews')->get()->sum('product_views_count'),
            'product_views_month' => $profile->products()
                ->with(['productViews' => function($query) {
                    $query->where('created_at', '>=', now()->subMonth());
                }])
                ->get()
                ->sum(fn($product) => $product->productViews->count()),
        ];

        // Top products by views
        $topProducts = $profile->products()
            ->withCount('productViews')
            ->orderByDesc('product_views_count')
            ->limit(5)
            ->get();

        // Recent profile views (last 7 days)
        $recentViews = $profile->profileViews()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('livewire.umkm.statistics', [
            'hasProfile' => true,
            'stats' => $stats,
            'topProducts' => $topProducts,
            'recentViews' => $recentViews,
        ]);
    }
}
