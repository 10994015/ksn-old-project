<?php

namespace App\Http\Livewire;

use App\Models\CertifiedBook;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CretifiedPassbook extends Component
{
    use WithFileUploads;
    public $passbookCover;
    public $bank;
    public $bankBranches;
    public $passbookAccountName;
    public $passbookAccount;
    public $openBank = [];
    public $toBeVerified = 0;
    public $data_passbook_verify = false;
    
    public function mount(){
        if(Auth::user()->data_auth) return redirect('/memberCentre');
        $this->data_passbook_verify = Auth::user()->data_passbook_verify;
        $this->openBank = [
            ["id"=>"004", "name"=>"台灣銀行"],
            ["id"=>"005", "name"=>"土地銀行"],
            ["id"=>"006", "name"=>"合作金庫"],
            ["id"=>"007", "name"=>"第一銀行"],
            ["id"=>"008", "name"=>"華南銀行"],
            ["id"=>"009", "name"=>"彰化銀行"],
            ["id"=>"011", "name"=>"上海商銀"],
            ["id"=>"012", "name"=>"台北富邦銀行"],
            ["id"=>"013", "name"=>"國泰世華銀行"],
            ["id"=>"016", "name"=>"高雄銀行"],
            ["id"=>"017", "name"=>"兆豐銀行"],
            ["id"=>"018", "name"=>"農業金庫"],
            ["id"=>"021", "name"=>"花旗銀行"],
            ["id"=>"022", "name"=>"美國銀行"],
            ["id"=>"025", "name"=>"首都銀行"],
            ["id"=>"048", "name"=>"王道銀行"],
            ["id"=>"050", "name"=>"台灣企銀"],
            ["id"=>"052", "name"=>"渣打商銀"],
            ["id"=>"053", "name"=>"台中商銀"],
            ["id"=>"054", "name"=>"京城銀行"],
            ["id"=>"075", "name"=>"東亞銀行"],
            ["id"=>"081", "name"=>"匯豐銀行"],
            ["id"=>"082", "name"=>"法國巴黎銀行"],
            ["id"=>"101", "name"=>"瑞興銀行"],
            ["id"=>"102", "name"=>"華泰商銀"],
            ["id"=>"103", "name"=>"台灣新光"],
            ["id"=>"104", "name"=>"台北五信"],
            ["id"=>"108", "name"=>"陽信銀行"],
            ["id"=>"700", "name"=>"中華郵政"],
            ["id"=>"803", "name"=>"聯邦銀行"],
            ["id"=>"805", "name"=>"遠東銀行"],
            ["id"=>"806", "name"=>"元大商業銀行"],
            ["id"=>"808", "name"=>"玉山銀行"],
            ["id"=>"809", "name"=>"凱基銀行"],
            ["id"=>"810", "name"=>"星展銀行"],
            ["id"=>"812", "name"=>"台新銀行"],
            ["id"=>"815", "name"=>"日盛銀行"],
            ["id"=>"816", "name"=>"安泰銀行"],
            ["id"=>"822", "name"=>"中國信託"],
            ["id"=>"823", "name"=>"將來銀行"],
            ["id"=>"824", "name"=>"連線商業銀行"],
            ["id"=>"826", "name"=>"樂天國際商業銀行"],
        ];
    }
    public function uploadPassbook(){
        $this->validate([
            'passbookCover' => 'required|image', 
            'bank' => 'required', 
            'bankBranches' => 'required', 
            'passbookAccountName' => 'required', 
            'passbookAccount' => 'required', 
        ],[
            'passbookCover.required'=>'*請上傳存摺封面',
            'passbookCover.image'=>'*檔案須為圖片',
            'bank.required'=>'*請選擇銀行',
            'bankBranches.required'=>'*請填寫銀行分行',
            'passbookAccountName.required'=>'*請填寫戶名',
            'passbookAccount.required'=>'*請填寫存摺帳號',
        ]);
        FacadesLog::info($this->passbookCover);
        $passbookCoverRandom = rand(0,99999);
        $cretified = new CertifiedBook();
        $passbookCoverName = Carbon::now()->timestamp. '.' . $passbookCoverRandom .'.'. $this->passbookCover->extension();
        $this->passbookCover->storeAs('uploads/cretified', $passbookCoverName);
        Storage::disk('s3')->setVisibility('uploads/cretified/'.$passbookCoverName, 'public');
        $cretified->passbook_cover = $passbookCoverName;
        $cretified->bank = $this->bank;
        $cretified->bank_branches = $this->bankBranches;
        $cretified->passbook_account_name = $this->passbookAccountName;
        $cretified->passbook_account = $this->passbookAccount;
        $cretified->user_id = Auth::id();


        $cretified->save();
        
        $this->data_passbook_verify = true;
        $user = User::find(Auth::id());
        $user->data_passbook_verify = true;
        $user->save();
        
        session()->flash('card-success', '上傳成功。');
        $this->toBeVerified = 1;
    }
    public function render()
    {
        return view('livewire.cretified-passbook')->layout('livewire.layouts.base');
    }
}
