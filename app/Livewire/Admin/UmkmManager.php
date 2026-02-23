<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UmkmManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public bool $showDetail = false;
    public ?UmkmProfile $selectedUmkm = null;

    // Form untuk tambah UMKM baru
    public bool $showAddForm = false;
    public string $ownerName = '';
    public string $ownerPhone = '';
    public string $businessName = '';
    public string $businessDescription = '';
    public string $businessAddress = '';
    public string $businessPhone = '';
    public bool $autoVerify = true;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function viewDetail(int $id)
    {
        $this->selectedUmkm = UmkmProfile::with(['user', 'products', 'photos'])->findOrFail($id);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedUmkm = null;
    }

    public function openAddForm()
    {
        $this->resetAddForm();
        $this->showAddForm = true;
    }

    public function closeAddForm()
    {
        $this->showAddForm = false;
        $this->resetAddForm();
    }

    private function resetAddForm()
    {
        $this->ownerName = '';
        $this->ownerPhone = '';
        $this->businessName = '';
        $this->businessDescription = '';
        $this->businessAddress = '';
        $this->businessPhone = '';
        $this->autoVerify = true;
    }

    public function createUmkm()
    {
        $this->validate([
            'ownerName' => 'required|string|max:255',
            'ownerPhone' => 'required|string|max:20',
            'businessName' => 'required|string|max:255',
            'businessAddress' => 'required|string|max:500',
        ], [
            'ownerName.required' => 'Nama pemilik wajib diisi.',
            'ownerPhone.required' => 'No. HP pemilik wajib diisi.',
            'businessName.required' => 'Nama usaha wajib diisi.',
            'businessAddress.required' => 'Alamat usaha wajib diisi.',
        ]);

        // Generate email dummy berdasarkan phone (untuk user yang tidak punya email)
        $dummyEmail = 'umkm_' . preg_replace('/[^0-9]/', '', $this->ownerPhone) . '@umkmpedia.local';
        
        // Cek apakah email dummy sudah ada
        $existingUser = User::where('email', $dummyEmail)->first();
        if ($existingUser) {
            $this->addError('ownerPhone', 'No. HP ini sudah terdaftar.');
            return;
        }

        // Buat user baru
        $user = User::create([
            'name' => $this->ownerName,
            'email' => $dummyEmail,
            'phone' => $this->ownerPhone,
            'password' => Hash::make('umkm' . substr($this->ownerPhone, -4)), // Password: umkm + 4 digit terakhir HP
            'role' => UserRole::UMKM,
            'email_verified_at' => now(), // Langsung verified karena didaftarkan admin
        ]);

        // Buat profil UMKM
        UmkmProfile::create([
            'user_id' => $user->id,
            'business_name' => $this->businessName,
            'description' => $this->businessDescription ?: null,
            'address' => $this->businessAddress,
            'phone' => $this->businessPhone ?: $this->ownerPhone,
            'is_verified' => $this->autoVerify,
            'verified_at' => $this->autoVerify ? now() : null,
        ]);

        $this->dispatch('toast', type: 'success', message: 'UMKM berhasil didaftarkan! Password: umkm' . substr($this->ownerPhone, -4));
        $this->closeAddForm();
    }

    public function verify(int $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
        $this->dispatch('toast', type: 'success', message: 'UMKM berhasil diverifikasi.');
        
        if ($this->showDetail && $this->selectedUmkm?->id === $id) {
            $this->selectedUmkm = $umkm->fresh(['user', 'products', 'photos']);
        }
    }

    public function unverify(int $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->update([
            'is_verified' => false,
            'verified_at' => null,
        ]);
        $this->dispatch('toast', type: 'success', message: 'Verifikasi UMKM dicabut.');
        
        if ($this->showDetail && $this->selectedUmkm?->id === $id) {
            $this->selectedUmkm = $umkm->fresh(['user', 'products', 'photos']);
        }
    }

    public function delete(int $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->delete();
        $this->dispatch('toast', type: 'success', message: 'UMKM berhasil dihapus.');
        $this->closeDetail();
    }

    public function render()
    {
        $query = UmkmProfile::with('user')
            ->when($this->search, function ($q) {
                $q->where('business_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->when($this->filterStatus !== '', function ($q) {
                if ($this->filterStatus === 'verified') {
                    $q->where('is_verified', true);
                } elseif ($this->filterStatus === 'pending') {
                    $q->where('is_verified', false);
                }
            })
            ->latest();

        return view('livewire.admin.umkm-manager', [
            'umkmList' => $query->paginate(10),
        ]);
    }
}
