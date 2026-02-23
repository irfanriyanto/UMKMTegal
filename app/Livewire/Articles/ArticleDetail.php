<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleDetail extends Component
{
    public string $slug;
    public ?Article $article = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->article = Article::with('author')
            ->published()
            ->where('slug', $slug)
            ->first();
    }

    public function render()
    {
        return view('livewire.articles.article-detail');
    }
}
