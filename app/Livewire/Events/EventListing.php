<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class EventListing extends Component
{
    use WithPagination;

    public function render()
    {
        $ongoingEvents = Event::query()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        $upcomingEvents = Event::query()
            ->where('is_active', true)
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        return view('livewire.events.event-listing', [
            'ongoingEvents' => $ongoingEvents,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
