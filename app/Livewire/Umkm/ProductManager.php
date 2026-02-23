<?php

namespace App\Livewire\Umkm;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Traits\CropsImageToSquare;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads, CropsImageToSquare;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    public string $name = '';
    public ?int $category_id = null;
    public string $description = '';
    public string $price = '';
    public bool $is_available = true;
    
    public $photo;
    public array $existingImages = [];
    public array $imagesToDelete = []; // Track images to delete on save

    // Batasan: maksimal 10 produk per UMKM, 1 foto per produk
    public const MAX_PRODUCTS_PER_UMKM = 10;
    public const MAX_PHOTOS_PER_PRODUCT = 1;

    protected function rules()
    {
        // Hitung foto yang tersisa (existing - yang akan dihapus)
        $remainingImages = count($this->existingImages) - count($this->imagesToDelete);
        
        // Foto wajib jika tidak ada foto tersisa dan tidak upload foto baru
        $photoRule = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        
        if ($remainingImages <= 0 && !$this->photo) {
            $photoRule = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }
        
        return [
            'name' => 'required|min:3|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|min:10|max:1000',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'photo' => $photoRule,
        ];
    }

    protected $messages = [
        'photo.required' => 'Foto produk wajib diupload.',
    ];

    public function create()
    {
        $profile = auth()->user()->umkmProfile;
        
        // Cek batas maksimal produk
        if ($profile && $profile->products()->count() >= self::MAX_PRODUCTS_PER_UMKM) {
            $this->dispatch('toast', type: 'error', message: 'Anda sudah mencapai batas maksimal ' . self::MAX_PRODUCTS_PER_UMKM . ' produk.');
            return;
        }
        
        $this->reset(['name', 'category_id', 'description', 'price', 'is_available', 'editingId', 'photo', 'existingImages', 'imagesToDelete']);
        $this->is_available = true;
        $this->isEditing = false;
        $this->showForm = true;
    }

    public function edit(int $id)
    {
        $profile = auth()->user()->umkmProfile;
        $product = Product::where('umkm_profile_id', $profile->id)->findOrFail($id);
        
        $this->editingId = $id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description ?? '';
        $this->price = $product->price;
        $this->is_available = $product->is_available;
        $this->existingImages = $product->images->toArray();
        $this->imagesToDelete = [];
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $profile = auth()->user()->umkmProfile;

        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'is_available' => $this->is_available,
        ];

        if ($this->isEditing) {
            $product = Product::where('umkm_profile_id', $profile->id)->findOrFail($this->editingId);
            $product->update($data);
            
            // Delete images that were marked for deletion
            foreach ($this->imagesToDelete as $imageId) {
                $image = ProductImage::where('product_id', $product->id)
                    ->where('id', $imageId)
                    ->first();
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
            
            $this->dispatch('toast', type: 'success', message: 'Produk berhasil diperbarui.');
        } else {
            $data['umkm_profile_id'] = $profile->id;
            $data['sort_order'] = $profile->products()->count();
            $product = Product::create($data);
            $this->dispatch('toast', type: 'success', message: 'Produk berhasil ditambahkan.');
        }

        // Handle photo upload with 1:1 crop (maksimal 1 foto per produk)
        if ($this->photo) {
            // Hapus foto lama jika ada (karena hanya boleh 1 foto)
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->path);
                $oldImage->delete();
            }
            
            $path = $this->cropAndStoreSquare($this->photo, 'product-images', 800);
            
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        $this->showForm = false;
        $this->reset(['name', 'category_id', 'description', 'price', 'is_available', 'editingId', 'photo', 'existingImages', 'imagesToDelete']);
    }

    public function deleteImage(int $imageId)
    {
        // Mark image for deletion (will be deleted on save)
        if (!in_array($imageId, $this->imagesToDelete)) {
            $this->imagesToDelete[] = $imageId;
            // Remove from existingImages display
            $this->existingImages = array_filter($this->existingImages, fn($img) => $img['id'] !== $imageId);
            $this->existingImages = array_values($this->existingImages);
            $this->dispatch('toast', type: 'info', message: 'Foto akan dihapus saat Anda menyimpan produk.');
        }
    }

    public function toggleAvailable(int $id)
    {
        $profile = auth()->user()->umkmProfile;
        $product = Product::where('umkm_profile_id', $profile->id)->findOrFail($id);
        $product->update(['is_available' => !$product->is_available]);
        $status = $product->is_available ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('toast', type: 'success', message: "Produk berhasil {$status}.");
    }

    public function delete(int $id)
    {
        $profile = auth()->user()->umkmProfile;
        $product = Product::where('umkm_profile_id', $profile->id)->findOrFail($id);
        
        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        
        $product->delete();
        $this->dispatch('toast', type: 'success', message: 'Produk berhasil dihapus.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset(['name', 'category_id', 'description', 'price', 'is_available', 'editingId', 'photo', 'existingImages', 'imagesToDelete']);
    }

    public function render()
    {
        $profile = auth()->user()->umkmProfile;
        $productCount = $profile ? $profile->products()->count() : 0;
        
        return view('livewire.umkm.product-manager', [
            'products' => $profile ? $profile->products()->with(['category', 'images'])->paginate(10) : collect(),
            'categories' => Category::ordered()->get(),
            'hasProfile' => $profile !== null,
            'productCount' => $productCount,
            'maxProducts' => self::MAX_PRODUCTS_PER_UMKM,
            'canAddMore' => $productCount < self::MAX_PRODUCTS_PER_UMKM,
        ]);
    }
}
