<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TicketOrder extends Component
{
    public function render()
    {
        return view('livewire.ticket-order')->layout('livewire.layouts.base');
    }
}
