<?php

namespace App\Http\Livewire;

use App\Models\Withdraw;
use Livewire\Component;

class WithdrawMoneyDetailed extends Component
{
    public $detail_id;
    public $platform;
    public $order_number;
    public $money;
    public $currency;
    public $status;
    public $warning;
    public $created_at;
    public $statusText;
    public $username;
    public function mount($id){
        $withdraw = Withdraw::find($id);
        $this->platform = $withdraw->platform;
        $this->order_number = $withdraw->order_number;
        $this->money = $withdraw->money;
        $this->currency = $withdraw->currency;
        $this->status = $withdraw->status;
        $this->warning = $withdraw->warning;
        $this->created_at = $withdraw->created_at;
        
        $statusArr = ['-2'=>'取消','-1'=>'交易失敗', '0'=>'待審核', '1'=>'交易成功'];
        $this->statusText = $statusArr[$this->status];
    }
    public function render()
    {
        return view('livewire.withdraw-money-detailed')->layout('livewire.layouts.base');
    }
}
