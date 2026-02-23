<?php

namespace App\Livewire\Home;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpcomingEvents extends Component
{
    public function render()
    {
        $events = Cache::remember('events.upcoming.4', 1800, function () {
            return Event::query()
                ->where('is_active', true)
                ->where('end_date', '>=', now())
                ->orderBy('start_date')
                ->limit(4)
                ->get();
        });

        return view('livewire.home.upcoming-events', [
            'events' => $events,
        ]);
    }
}
