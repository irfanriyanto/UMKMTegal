<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class MessageManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public bool $showDetail = false;
    public ?ContactMessage $selectedMessage = null;

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
        $this->selectedMessage = ContactMessage::findOrFail($id);
        
        // Mark as read when viewing
        if (!$this->selectedMessage->is_read) {
            $this->selectedMessage->markAsRead();
        }
        
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedMessage = null;
    }

    public function markAsRead(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();
        $this->dispatch('toast', type: 'success', message: 'Pesan ditandai sudah dibaca.');
    }

    public function markAsUnread(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => false]);
        $this->dispatch('toast', type: 'success', message: 'Pesan ditandai belum dibaca.');
        
        if ($this->showDetail && $this->selectedMessage?->id === $id) {
            $this->selectedMessage = $message->fresh();
        }
    }

    public function delete(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        $this->dispatch('toast', type: 'success', message: 'Pesan berhasil dihapus.');
        $this->closeDetail();
    }

    public function render()
    {
        $query = ContactMessage::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('subject', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus !== '', function ($q) {
                if ($this->filterStatus === 'unread') {
                    $q->where('is_read', false);
                } elseif ($this->filterStatus === 'read') {
                    $q->where('is_read', true);
                }
            })
            ->latest();

        return view('livewire.admin.message-manager', [
            'messages' => $query->paginate(10),
            'unreadCount' => ContactMessage::unread()->count(),
        ]);
    }
}
