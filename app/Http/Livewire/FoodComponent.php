<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FoodComponent extends Component
{
    public function render()
    {
        return view('livewire.food-component')->layout('livewire.layouts.base');
    }
}
