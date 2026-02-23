<?php

namespace App\Livewire\Contact;

use App\Models\Faq;
use Livewire\Component;

class FaqSection extends Component
{
    public function render()
    {
        return view('livewire.contact.faq-section', [
            'faqs' => Faq::active()->ordered()->get(),
        ]);
    }
}
