<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Statement extends Component
{
    public function render()
    {
        return view('livewire.statement')->layout('livewire.layouts.base');
    }
}
