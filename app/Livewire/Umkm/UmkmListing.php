<?php

namespace App\Livewire\Umkm;

use App\Models\UmkmProfile;
use Livewire\Component;
use Livewire\WithPagination;

class UmkmListing extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortOrder = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortOrder' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'sortBy', 'sortOrder']);
        $this->resetPage();
    }

    public function render()
    {
        $umkmList = UmkmProfile::query()
            ->with(['photos', 'user']) // Eager loading
            ->withCount('products') // Eager load count
            ->where('is_verified', true)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('business_name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%")
                      ->orWhere('address', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate(12);

        return view('livewire.umkm.umkm-listing', [
            'umkmList' => $umkmList,
        ]);
    }
}
