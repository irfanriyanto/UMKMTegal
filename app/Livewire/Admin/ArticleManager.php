<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Traits\CropsImageToSquare;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ArticleManager extends Component
{
    use WithPagination, WithFileUploads, CropsImageToSquare;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $content = '';
    public string $category = '';
    public $featured_image;
    public bool $is_published = false;

    public ?string $existingFeaturedImage = null;

    protected function rules()
    {
        // Foto wajib untuk artikel baru, opsional untuk edit jika sudah ada foto
        $imageRule = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        
        if (!$this->isEditing && !$this->existingFeaturedImage) {
            $imageRule = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }
        
        return [
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:20',
            'category' => 'nullable|max:100',
            'featured_image' => $imageRule,
        ];
    }

    protected $messages = [
        'featured_image.required' => 'Gambar utama wajib diupload.',
    ];

    public function create()
    {
        $this->reset(['title', 'content', 'category', 'featured_image', 'is_published', 'editingId', 'existingFeaturedImage']);
        $this->isEditing = false;
        $this->showForm = true;
    }

    public function edit(int $id)
    {
        $article = Article::findOrFail($id);
        $this->editingId = $id;
        $this->title = $article->title;
        $this->content = $article->content;
        $this->category = $article->category ?? '';
        $this->is_published = $article->is_published;
        $this->existingFeaturedImage = $article->featured_image;
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . uniqid(),
            'content' => $this->content,
            'category' => $this->category ?: null,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ];

        if ($this->isEditing) {
            $article = Article::findOrFail($this->editingId);
            $article->update($data);
            
            if ($this->featured_image) {
                if ($article->featured_image) {
                    Storage::disk('public')->delete($article->featured_image);
                }
                $path = $this->cropAndStoreSquare($this->featured_image, 'articles', 800);
                $article->update(['featured_image' => $path]);
            }
            
            $this->dispatch('toast', type: 'success', message: 'Artikel berhasil diperbarui.');
        } else {
            $data['author_id'] = auth()->id();
            $article = Article::create($data);
            
            if ($this->featured_image) {
                $path = $this->cropAndStoreSquare($this->featured_image, 'articles', 800);
                $article->update(['featured_image' => $path]);
            }
            
            $this->dispatch('toast', type: 'success', message: 'Artikel berhasil ditambahkan.');
        }

        $this->showForm = false;
        $this->reset(['title', 'content', 'category', 'featured_image', 'is_published', 'editingId']);
    }

    public function togglePublish(int $id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'is_published' => !$article->is_published,
            'published_at' => !$article->is_published ? now() : null,
        ]);
        
        $status = $article->is_published ? 'dipublikasikan' : 'disembunyikan';
        $this->dispatch('toast', type: 'success', message: "Artikel berhasil {$status}.");
    }

    public function delete(int $id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        
        $article->delete();
        $this->dispatch('toast', type: 'success', message: 'Artikel berhasil dihapus.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset(['title', 'content', 'category', 'featured_image', 'is_published', 'editingId', 'existingFeaturedImage']);
    }

    public function render()
    {
        return view('livewire.admin.article-manager', [
            'articles' => Article::with('author')->latest()->paginate(10),
        ]);
    }
}
