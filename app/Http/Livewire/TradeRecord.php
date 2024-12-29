<?php

namespace App\Http\Livewire;

use App\Models\StorePointRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
class TradeRecord extends Component
{
    use WithPagination;
    public function render()
    {
        $stores = StorePointRecord::where([['member_id', Auth::id()], ['store_type', '<', 3]])->orderBy('created_at', 'DESC')->paginate(20);
        return view('livewire.trade-record', ['stores'=>$stores])->layout('livewire.layouts.base');
    }
}
