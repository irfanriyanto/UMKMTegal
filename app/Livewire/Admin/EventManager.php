<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Traits\CropsImageToSquare;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EventManager extends Component
{
    use WithPagination, WithFileUploads, CropsImageToSquare;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $description = '';
    public string $location = '';
    public string $start_date = '';
    public string $end_date = '';
    public $banner_image;
    public bool $is_active = true;

    public ?string $existingBannerImage = null;

    protected function rules()
    {
        // Foto wajib untuk event baru, opsional untuk edit jika sudah ada foto
        $imageRule = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        
        if (!$this->isEditing && !$this->existingBannerImage) {
            $imageRule = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }
        
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable',
            'location' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner_image' => $imageRule,
        ];
    }

    protected $messages = [
        'banner_image.required' => 'Banner image wajib diupload.',
    ];

    public function create()
    {
        $this->reset(['name', 'description', 'location', 'start_date', 'end_date', 'banner_image', 'is_active', 'editingId', 'existingBannerImage']);
        $this->is_active = true;
        $this->isEditing = false;
        $this->showForm = true;
    }

    public function edit(int $id)
    {
        $event = Event::findOrFail($id);
        $this->editingId = $id;
        $this->name = $event->name;
        $this->description = $event->description ?? '';
        $this->location = $event->location ?? '';
        $this->start_date = $event->start_date->format('Y-m-d\TH:i');
        $this->end_date = $event->end_date->format('Y-m-d\TH:i');
        $this->is_active = $event->is_active;
        $this->existingBannerImage = $event->banner_image;
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . uniqid(),
            'description' => $this->description ?: null,
            'location' => $this->location ?: null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            $event = Event::findOrFail($this->editingId);
            $event->update($data);
            
            if ($this->banner_image) {
                if ($event->banner_image) {
                    Storage::disk('public')->delete($event->banner_image);
                }
                $path = $this->cropAndStoreSquare($this->banner_image, 'events', 800);
                $event->update(['banner_image' => $path]);
            }
            
            $this->dispatch('toast', type: 'success', message: 'Event berhasil diperbarui.');
        } else {
            $event = Event::create($data);
            
            if ($this->banner_image) {
                $path = $this->cropAndStoreSquare($this->banner_image, 'events', 800);
                $event->update(['banner_image' => $path]);
            }
            
            $this->dispatch('toast', type: 'success', message: 'Event berhasil ditambahkan.');
        }

        $this->showForm = false;
        $this->reset(['name', 'description', 'location', 'start_date', 'end_date', 'banner_image', 'is_active', 'editingId']);
    }

    public function toggleActive(int $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['is_active' => !$event->is_active]);
        
        $status = $event->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('toast', type: 'success', message: "Event berhasil {$status}.");
    }

    public function delete(int $id)
    {
        $event = Event::findOrFail($id);
        
        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }
        
        $event->delete();
        $this->dispatch('toast', type: 'success', message: 'Event berhasil dihapus.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset(['name', 'description', 'location', 'start_date', 'end_date', 'banner_image', 'is_active', 'editingId', 'existingBannerImage']);
    }

    public function render()
    {
        return view('livewire.admin.event-manager', [
            'events' => Event::latest()->paginate(10),
        ]);
    }
}
