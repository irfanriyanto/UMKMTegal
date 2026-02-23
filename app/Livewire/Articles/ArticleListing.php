<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleListing extends Component
{
    use WithPagination;

    public ?string $category = null;

    protected $queryString = [
        'category' => ['except' => null],
    ];

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $articles = Article::query()
            ->with('author') // Eager loading
            ->where('is_published', true)
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('livewire.articles.article-listing', [
            'articles' => $articles,
        ]);
    }
}
