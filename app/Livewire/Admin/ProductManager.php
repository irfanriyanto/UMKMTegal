<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $categoryFilter = null;
    public ?string $statusFilter = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => null],
        'statusFilter' => ['except' => null],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleAvailable(int $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_available' => !$product->is_available]);
        $status = $product->is_available ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('toast', type: 'success', message: "Produk berhasil {$status}.");
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->dispatch('toast', type: 'success', message: 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $query = Product::with(['umkmProfile', 'category', 'images'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhereHas('umkmProfile', function ($q) {
                      $q->where('business_name', 'like', "%{$this->search}%");
                  });
            })
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->statusFilter === 'active', fn($q) => $q->where('is_available', true))
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('is_available', false))
            ->latest();

        return view('livewire.admin.product-manager', [
            'products' => $query->paginate(10),
            'categories' => Category::ordered()->get(),
        ]);
    }
}
