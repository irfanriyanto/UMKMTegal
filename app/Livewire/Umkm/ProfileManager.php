<?php

namespace App\Livewire\Umkm;

use App\Models\UmkmProfile;
use App\Models\UmkmPhoto;
use App\Traits\CropsImageToSquare;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfileManager extends Component
{
    use WithFileUploads, CropsImageToSquare;

    public ?UmkmProfile $profile = null;
    
    public string $business_name = '';
    public string $description = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public ?string $instagram = '';
    public ?string $facebook = '';
    public ?string $whatsapp = '';
    
    public ?float $latitude = null;
    public ?float $longitude = null;
    
    public $photo;
    public array $existingPhotos = [];
    public array $photosToDelete = []; // Track photos to delete on save

    // Batasan: maksimal 1 foto per UMKM
    public const MAX_PHOTOS_PER_UMKM = 1;

    protected function rules()
    {
        // Hitung foto yang tersisa (existing - yang akan dihapus)
        $remainingPhotos = count($this->existingPhotos) - count($this->photosToDelete);
        
        // Foto wajib jika tidak ada foto tersisa dan tidak upload foto baru
        $photoRule = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        
        if ($remainingPhotos <= 0 && !$this->photo) {
            $photoRule = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }
        
        return [
            'business_name' => 'required|min:3|max:100',
            'description' => 'required|min:20|max:1000',
            'phone' => 'required|min:10|max:15',
            'email' => 'nullable|email',
            'address' => 'required|min:10|max:255',
            'instagram' => 'nullable|max:100',
            'facebook' => 'nullable|max:100',
            'whatsapp' => 'nullable|max:15',
            'photo' => $photoRule,
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    protected $messages = [
        'photo.required' => 'Foto usaha wajib diupload.',
    ];

    public function mount()
    {
        $this->profile = auth()->user()->umkmProfile;
        
        if ($this->profile) {
            $this->business_name = $this->profile->business_name;
            $this->description = $this->profile->description ?? '';
            $this->phone = $this->profile->phone ?? '';
            $this->email = $this->profile->email ?? '';
            $this->address = $this->profile->address ?? '';
            $this->instagram = $this->profile->social_media['instagram'] ?? '';
            $this->facebook = $this->profile->social_media['facebook'] ?? '';
            $this->whatsapp = $this->profile->social_media['whatsapp'] ?? '';
            $this->latitude = $this->profile->latitude ? (float) $this->profile->latitude : null;
            $this->longitude = $this->profile->longitude ? (float) $this->profile->longitude : null;
            $this->existingPhotos = $this->profile->photos->toArray();
            $this->photosToDelete = [];
        }
    }

    /**
     * Handle location selection from map picker
     */
    public function setLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'business_name' => $this->business_name,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'social_media' => [
                'instagram' => $this->instagram,
                'facebook' => $this->facebook,
                'whatsapp' => $this->whatsapp,
            ],
        ];

        if ($this->profile) {
            $this->profile->update($data);
            
            // Delete photos that were marked for deletion
            foreach ($this->photosToDelete as $photoId) {
                $photo = UmkmPhoto::where('umkm_profile_id', $this->profile->id)
                    ->where('id', $photoId)
                    ->first();
                if ($photo) {
                    Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
            $this->photosToDelete = [];
            
            $this->dispatch('toast', type: 'success', message: 'Profil usaha berhasil diperbarui.');
        } else {
            $data['user_id'] = auth()->id();
            $this->profile = UmkmProfile::create($data);
            $this->dispatch('toast', type: 'success', message: 'Profil usaha berhasil dibuat. Anda sekarang bisa menambahkan produk!');
        }

        // Handle photo upload with 1:1 crop (maksimal 1 foto per UMKM)
        if ($this->photo && is_object($this->photo)) {
            // Hapus foto lama jika ada (karena hanya boleh 1 foto)
            foreach ($this->profile->photos as $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto->path);
                $oldPhoto->delete();
            }
            
            $path = $this->cropAndStoreSquare($this->photo, 'umkm-photos', 800);
            
            // Create new photo as primary
            UmkmPhoto::create([
                'umkm_profile_id' => $this->profile->id,
                'path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
        
        $this->existingPhotos = $this->profile->fresh()->photos->toArray();
        
        // Reset photo property to prevent temporaryUrl error
        $this->reset('photo');
    }

    public function deletePhoto(int $photoId)
    {
        // Mark photo for deletion (will be deleted on save)
        if (!in_array($photoId, $this->photosToDelete)) {
            $this->photosToDelete[] = $photoId;
            // Remove from existingPhotos display
            $this->existingPhotos = array_filter($this->existingPhotos, fn($photo) => $photo['id'] !== $photoId);
            $this->existingPhotos = array_values($this->existingPhotos);
            $this->dispatch('toast', type: 'info', message: 'Foto akan dihapus saat Anda menyimpan profil.');
        }
    }

    public function cancelPhotoDelete()
    {
        // Restore photos that were marked for deletion
        if ($this->profile) {
            $this->existingPhotos = $this->profile->photos->toArray();
            $this->photosToDelete = [];
        }
    }

    public function render()
    {
        $photoCount = $this->profile ? $this->profile->photos()->count() : 0;
        
        return view('livewire.umkm.profile-manager', [
            'photoCount' => $photoCount,
            'maxPhotos' => self::MAX_PHOTOS_PER_UMKM,
            'canAddPhoto' => $photoCount < self::MAX_PHOTOS_PER_UMKM,
        ]);
    }
}
