<?php

namespace App\Livewire\Umkm;

use App\Models\ProfileView;
use App\Models\UmkmProfile;
use Livewire\Component;

class UmkmDetail extends Component
{
    public string $slug;
    public ?UmkmProfile $profile = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->profile = UmkmProfile::with(['user', 'photos', 'products'])
            ->where('slug', $slug)
            ->first();

        if ($this->profile) {
            ProfileView::recordView($this->profile->id, request()->ip());
        }
    }

    public function render()
    {
        return view('livewire.umkm.umkm-detail');
    }
}
