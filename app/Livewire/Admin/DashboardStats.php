<?php

namespace App\Livewire\Admin;

use App\Models\UmkmProfile;
use App\Models\Product;
use App\Models\Article;
use App\Models\Event;
use App\Models\ContactMessage;
use App\Models\ProfileView;
use App\Models\ProductView;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class DashboardStats extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $stats = [
            'total_users' => User::count(),
            'total_umkm' => UmkmProfile::count(),
            'verified_umkm' => UmkmProfile::where('is_verified', true)->count(),
            'total_products' => Product::count(),
            'total_articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'total_events' => Event::count(),
            'active_events' => Event::where('start_date', '>=', $today)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'profile_views_today' => ProfileView::whereDate('created_at', $today)->count(),
            'product_views_today' => ProductView::whereDate('created_at', $today)->count(),
        ];

        return view('livewire.admin.dashboard-stats', [
            'stats' => $stats,
        ]);
    }
}
