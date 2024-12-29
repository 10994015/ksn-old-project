<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowComponent extends Component
{
    public function render()
    {
        return view('livewire.show-component')->layout('livewire.layouts.base');
    }
}
