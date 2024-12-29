<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModifyData extends Component
{
    public $username;
    public $name;
    public $phone;
    public function mount(){
        $this->username = Auth::user()->username;
        $this->name = Auth::user()->name;
        $this->phone = Auth::user()->phone;
    }
    public function updateName(){
        $user = User::find(Auth::id());
        $user->name = $this->name;
        $user->save();
        session()->flash('message', '更改成功！');
    }
    public function render()
    {
        return view('livewire.modify-data')->layout('livewire.layouts.base');
    }
}
