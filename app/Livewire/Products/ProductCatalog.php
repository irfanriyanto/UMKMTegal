<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $categoryId = null;
    public ?float $minPrice = null;
    public ?float $maxPrice = null;
    public string $sortBy = 'created_at';
    public string $sortOrder = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryId' => ['except' => null],
        'minPrice' => ['except' => null],
        'maxPrice' => ['except' => null],
        'sortBy' => ['except' => 'created_at'],
        'sortOrder' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categoryId', 'minPrice', 'maxPrice', 'sortBy', 'sortOrder']);
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['umkmProfile', 'category', 'images']) // Eager loading
            ->where('is_available', true)
            ->whereHas('umkmProfile', fn($q) => $q->where('is_verified', true))
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate(12);

        return view('livewire.products.product-catalog', [
            'products' => $products,
            'categories' => Category::ordered()->get(),
        ]);
    }
}
