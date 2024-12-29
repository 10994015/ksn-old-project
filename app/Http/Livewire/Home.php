<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Answer as ModelsAnswer;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $date; 
    public $year; 
    public $month; 
    public $hour; 
    public $nowTime; 
    public $twoHour; 
    public function mount(){
        $nowDate = date('Y-m-d H:i');
        $answer = ModelsAnswer::where('bet_time', $nowDate)->count();
        if($answer == 0){
            $this->store();
        }
    }
   
    public function render()
    {
        $foundrys = ["紙盒代工", "紙袋包裝", "梳子包裝", "髮圈代工", "襪子包裝", "飾品代工", "髮夾包裝", "充電線包裝", "鈕扣包裝", "手環代工", "吊牌加工", "粉撲包裝"];
        return view('livewire.home', ["foundrys"=>$foundrys])->layout('livewire/layouts/base');
    }
}
