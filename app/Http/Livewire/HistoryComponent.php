<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HistoryComponent extends Component
{
    public function render()
    {
        return view('livewire.history-component')->layout('livewire.layouts.base');
    }
}
