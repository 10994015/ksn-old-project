<?php

namespace App\Http\Livewire;

use App\Models\Betlist;
use App\Models\CertifiedBook;
use App\Models\StorePointRecord;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPUnit\Framework\isNull;

class WithdrawMoney extends Component
{
    use WithPagination;
    public $myMoney;
    public $outMoney;
    public $bankAccount;
    public $moneyCode;
    public function mount(){
        // if(Auth::user()->data_auth != 1){
        //     return redirect('/certified');
        // }
        $this->myMoney = Auth::user()->money;
        $this->outMoney = 0;
        $this->bankAccount = CertifiedBook::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->first()->passbook_account ?? "尚未設定帳戶";
    }
    public function outMoneyFn(){
        if($this->moneyCode != Auth::user()->money_code){
            session()->flash('error', '提領密碼輸入錯誤！');
            return;
        }
        if($this->outMoney < 500){
            session()->flash('error', '最低提領金額為500');
            return;
        }
        if($this->outMoney > $this->myMoney){
            session()->flash('error', '餘額不足');
            return;
        }
        $casino_codes = Auth::user()->casino_codes;
        $gap_money = 0;
        $gap_money = StorePointRecord::where([['member_id', Auth::id()], ['store_type', '<>', '3'], ['store', 1]])->sum('money') ?? 0;
        $play_money = Betlist::where('user_id', Auth::id())->sum('money');
        $updated_money = $gap_money - $play_money + $casino_codes;
        if(($updated_money) > 0 ){
            session()->flash('error', '提領失敗，洗碼量不足 $' . $updated_money);
            return;
        }
        $lastStore = StorePointRecord::where([['member_id', Auth::id()], ['store_type', '<>', '3'], ['store', 1]])->orderBy('created_at', 'DESC')->first();
        if(isset($lastStore->created_at)){
            $playMoney = Betlist::where([['created_at', '>=' , $lastStore->created_at], ['user_id', Auth::id()]])->sum('money') ?? 0;
        }else{
            $playMoney = 0;
        }

        if(!$lastStore){
            session()->flash('error', '提領失敗，洗碼量不足 $' . $updated_money);
            return;
        }

        $gap_money = (int)$lastStore->money - (int)$playMoney;

        $updated_money = $gap_money + $casino_codes;

        if($updated_money > 0){
            session()->flash('error', '提領失敗，洗碼量不足 $' . $updated_money);
            return;
        }


        if(Withdraw::where('user_id', Auth::id())->orderBy('id', 'DESC')->count() > 0){
            if(Withdraw::where('user_id', Auth::id())->orderBy('id', 'DESC')->first()->status ==0){
                session()->flash('error', '提領失敗，您上次的提領尚未完成，請勿重複提領');
                return;
            }
        }

        $rand = rand(10000, 99999);
        $order_number = "SA" . $rand . date('YmdHi');

        $with = Withdraw::where([['user_id', Auth::id()], ['created_at', '>=', date('Y-m-d 00:00:00')]])->sum('money');

        if($with > 2000000){
            session()->flash('error', '提領失敗！每日提領限額為NTD 2,000,000！');
            return;
        }
        DB::beginTransaction();
        try{
            $withdraw = new Withdraw();
            $withdraw->user_id = Auth::id();
            $withdraw->order_number = $order_number;
            $withdraw->money = $this->outMoney;
            $withdraw->status = 0;
            $withdraw->platform = "KSN";
            $withdraw->store_type = 2;
            $withdraw->proxy_id = 0;
            $withdraw->username = Auth::user()->username;
            $withdraw->warning = "待審核，審核時間須為1至3天工作天";
            $withdraw->save();

            $user = User::find(Auth::id());
            $user->money = $this->myMoney - $this->outMoney;
            $user->handle_money = $user->handle_money + $this->outMoney;
            $user->casino_codes = 0;
            $user->save();

            $this->myMoney = $this->myMoney - $this->outMoney;
            $this->outMoney = 0;
            DB::commit();
            session()->flash('message', '轉出成功！請等待1至3天的作業時間');
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('error', '提領失敗！伺服器連線錯誤！請再重試一次！');
        }


    }
    public function render()
    {
        $withdraw = Withdraw::where('user_id', Auth::id())->orderBy('id', 'DESC')->paginate(20);
        return view('livewire.withdraw-money', ['withdraw'=>$withdraw])->layout('livewire.layouts.base');
    }
}
