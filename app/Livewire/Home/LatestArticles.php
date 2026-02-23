<?php

namespace App\Livewire\Home;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class LatestArticles extends Component
{
    public function render()
    {
        $articles = Cache::remember('articles.latest.4', 1800, function () {
            return Article::query()
                ->with('author') // Eager loading
                ->where('is_published', true)
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        });

        return view('livewire.home.latest-articles', [
            'articles' => $articles,
        ]);
    }
}
