<?php

namespace App\Http\Livewire;

use App\Models\Certified as ModelsCertified;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
class Certified extends Component
{
    use WithFileUploads;
    public $cardFront;
    public $cardBack;
    public $numberId;
    public $toBeVerified = 0;
    public $data_auth_verify = false;
    public function mount(){
        if(Auth::user()->data_auth == 1) return redirect('/memberCentre');
        $this->data_auth_verify = Auth::user()->data_auth_verify;

    }
    public function uploadNumberId(){
        $this->validate([
            'cardFront' => 'required|image', 
            'cardBack' => 'required|image', 
            'numberId' => 'required|size:10', 
        ],[
            'cardFront.required'=>'*請上傳身分證正面',
            'cardFront.image'=>'*檔案須為圖片',
            'cardBack.required'=>'*請上傳身分證背面',
            'cardBack.image'=>'*檔案須為圖片',
            'numberId.required'=>'*請填寫身分證字號',
            'numberId.size'=>'*身分證字號須為10碼',
        ]);
        $cardFrontRandom = rand(0,99999);
        $cardBackRandom = rand(0,99999);
        $cretified = new ModelsCertified();
        $cardFrontName = Carbon::now()->timestamp. '.' . $cardFrontRandom .'.'. $this->cardFront->extension();
        $cardBackName = Carbon::now()->timestamp. '.' . $cardBackRandom . '.' . $this->cardBack->extension();
        $this->cardFront->storeAs('uploads/cretified', $cardFrontName);
        $this->cardBack->storeAs('uploads/cretified', $cardBackName);
        Storage::disk('s3')->setVisibility('uploads/cretified/'.$cardFrontName, 'public');
        Storage::disk('s3')->setVisibility('uploads/cretified/'.$cardBackName, 'public');
        $cretified->card_front = $cardFrontName;
        $cretified->card_back = $cardBackName;

        $cretified->number_id = $this->numberId;
        $cretified->user_id = Auth::id();

        $cretified->save();

        $this->data_auth_verify = true;
        $user = User::find(Auth::id());
        $user->data_auth_verify = true;
        $user->save();
        session()->flash('card-success', '上傳成功。');

        $this->toBeVerified = 1;
    }
    public function render()
    {
        return view('livewire.certified')->layout('livewire.layouts.base');
    }
}
