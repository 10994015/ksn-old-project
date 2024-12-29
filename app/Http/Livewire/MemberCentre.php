<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberCentre extends Component
{
    public $username;
    public $name;
    public $phone;
    public $phone_verification;
    public $point_lock;
    public $money;
    public $data_auth;
    public $is_lock;
    public $handle_money;
    public function mount(){
        $this->username = Auth::user()->username;
        $this->name = Auth::user()->name;
        $this->phone = Auth::user()->phone;
        $this->phone_verification = Auth::user()->phone_verification;
        $this->point_lock = Auth::user()->point_lock;
        $this->money = Auth::user()->money;
        $this->data_auth = Auth::user()->data_auth;
        $this->is_lock = Auth::user()->point_lock;
        $this->handle_money = Auth::user()->handle_money;
    }
    public function render()
    {
        return view('livewire.member-centre')->layout('livewire.layouts.base');
    }
}
