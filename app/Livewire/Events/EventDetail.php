<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class EventDetail extends Component
{
    public string $slug = '';
    public ?Event $event = null;

    public function mount(?string $slug = null)
    {
        $this->slug = $slug ?? '';
        
        if (!empty($this->slug)) {
            $this->event = Event::with('umkmProfiles')
                ->where('slug', $this->slug)
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.events.event-detail');
    }
}
