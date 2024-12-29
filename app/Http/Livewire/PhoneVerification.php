<?php

namespace App\Http\Livewire;

use App\Models\PhoneCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\Carbon;
class PhoneVerification extends Component
{
    public $code;
    public $phone_number;
    protected $listeners = ['verification' => 'verification'];
    public function mount(){
        if(Auth::user()->phone_verification == 1){
            return redirect('/');
        }

        $this->phone_number = '886' . substr(Auth::user()->phone, 2);
    }
    public function verification(){
        $pc = PhoneCode::where([['user_id', Auth::id()]])->orderBy('created_at', 'DESC')->first();
        $diff_in_minutes = (Carbon::now())->diffInMinutes($pc->created_at, false);
        // verificationFailFn
        if($pc->code !== $this->code){
            $this->dispatchBrowserEvent('verificationFailFn');
            return;
        }
        if($diff_in_minutes >  -3 && $diff_in_minutes <=0){
            $user = User::where('id', Auth::id())->first();
            $user->phone_verification = 1;
            $user->save();
            $this->dispatchBrowserEvent('verificationSuccessFn');
        }else{
            $this->dispatchBrowserEvent('verificationFailFn');
        }
    }
    public function sendCode(){
        $code = rand(1000, 9999);

        $basic  = new \Vonage\Client\Credentials\Basic(env('PHONE_API_KEY'), env('PHONE_API_KEY_PASSWORD'));
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS('85268191721', 'KSN E-commerce', 'KSN電商訊息:您的驗證碼為 '.$code.' 請於一分鐘內完成驗證')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            $pc = new PhoneCode();
            $pc->user_id = Auth::id();
            $pc->code = $code;
            $pc->save();
        }
    }
    public function render()
    {
        return view('livewire.phone-verification')->layout('livewire.layouts.base');
    }
}
