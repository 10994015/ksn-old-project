<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\GameInfos;
use App\Models\GameStatu;
use App\Models\RiskBet;
use App\Models\Answer as ModelsAnswer;
use App\Models\Control;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Vonage\Client\Exception\Exception;
class Airplane extends Component
{
    public $isLoad;
    public $betMoney = 0;
    public $air;
    public $myDoller;
    public $accMoney;
    public $winMoney = 0;
    public $odds;
    public $bsodds;
    public $statu;
    public $chips = 0;
    public $is_beted_guess;
    public $level;
    public $betlist;
    public $single_term; //定位膽單期限額
    public $single_bet_limit; //定位膽單注限額
    public $bs_single_term; //大小單雙單期限額 
    public $bs_single_bet_limit; //大小單雙單注限額
    protected $listeners  = ['sendTime'=>'sendTime', 'noneLoad'=>'noneLoad', 'chkBet'=>'chkBet', 'calcMoney'=>'calcMoney', 'updateMyMoney'=>'updateMyMoney', 'riskCalcMoney'=>'riskCalcMoney', 'isRiskFn'=>'isRiskFn', 'updateTrend'=>'updateTrend', 'watchStatu'=>'watchStatu', 'isBeted'=>'isBeted', 'initFn'=>'initFn', 'updateCycleNumber'=>'updateCycleNumber', 'reportChkFn'=>'reportChkFn'];
    public function mount(){
            if(DB::table('gamestatus')->where('gamenumber', 23)->first()->maintenance == 1){
                return redirect('/notfound');
            }
            if(Auth::user()->money <= 0){
                return redirect('/');
            }
            if(Auth::user()->phone_verification == 0){
                return redirect('/phoneVerification');
            }
            if(DB::table('store_point_record')->where('member_id', Auth::id())->count() <= 0){
                return redirect('/notfound');
            }
            $isAns = Answer::where('bet_time', date('Y-m-d H:i'))->count();
            $isOneDayAns = Answer::where('bet_time', date('Y-m-d H:i', strtotime("+1 day")))->count();
            
            try{
                if($isAns == 0){
                    $this->store();
                }
            }
            catch (\Exception $e) {
                $this->deleteTodayAnswer();
                $this->store();
                return redirect('/airplane');
            }
            try{
                if($isOneDayAns==0){
                    $this->storeOneDay();
                }
            }catch (\Exception $e) {
                $this->deleteAfterAnswer();
                $this->storeOneDay();
                return redirect('/airplane');
            }

            if(intval(date("H"))==0 && intval(date("i")) <= 5){
                $isBeforeAns = Answer::where('bet_time', date('Y-m-d H:i', strtotime("-1 day")))->count();
                try{
                    if($isBeforeAns == 0){
                        $this->storeBefore();
                    }
                }catch (\Exception $e) {
                    $this->deleteBeforeAnswer();
                    $this->storeBefore();
                    return redirect('/airplane');
                }
            }
            
            $this->statu = GameStatu::where('gamenumber', 23)->first()->statu;
    
            $user = User::where('id', Auth::id())->first();
            $user->save();
            $nowDate = date('Y-m-d H:i');
            $answer = ModelsAnswer::where('bet_time', $nowDate)->count();
          
            $this->myDoller = Auth::user()->money;
    
            if($this->myDoller >= 200000){
                $this->level = 6;
            }elseif($this->myDoller >= 100000){
                $this->level = 5;
            }elseif($this->myDoller >= 10000){
                $this->level = 4;
            }elseif($this->myDoller >= 1000){
                $this->level = 3;
            }elseif($this->myDoller >= 100){
                $this->level = 2;
            }else{
                $this->level = 1;
            }
            $this->betlist = Betlist::where('user_id', Auth::id())->orderBy('id', 'DESC')->get(); //record.blade
    }
    public function isBeted(){
        $bl = Betlist::where('user_id', Auth::id())->whereBetween('created_at', [date("Y-m-d H:i:00"),date("Y-m-d H:i:59") ])->get();
        if($bl->count() > 0){
            $this->dispatchBrowserEvent('isbetedFn', ['isBet'=>true, 'blArr'=>json_decode(json_encode($bl)) ]);

        }
    }
   
    public function updateCycleNumber(){
        $riskTime = date('Y-m-d H:i');
        $number = Answer::where('bet_time',$riskTime)->first()->number;
        $this->dispatchBrowserEvent('updateCycle', ['number'=>$number]);
    }
    public function sendTime($isInit){
        $beforeTime = date('Y-m-d H:i', strtotime("-4 minute"));
        if(date('s')<37){
            $beforeTime = date('Y-m-d H:i', strtotime("-5 minute"));
            $nowTime = date('Y-m-d H:i', strtotime("-1 minute"));
        }else{
            $beforeTime = date('Y-m-d H:i', strtotime("-4 minute"));
            $nowTime = date('Y-m-d H:i');
        }
        
        $riskTime = date('Y-m-d H:i');
        $answer = Answer::whereBetween('bet_time', [$beforeTime, $nowTime])->get();
        $riskAnswer = Answer::where('bet_time',$riskTime)->get();
        $this->dispatchBrowserEvent('sendAnswer', ['answer'=>$answer, 'riskAnswer'=>$riskAnswer, 'isInit'=>$isInit]);
    }
    public function isRiskFn(){
        $gameinfo = GameInfos::where('gamenumber', '23')->first();
        if($gameinfo->mode == 1){
            $nowTime = date('Y-m-d H:i');
            $answer = Answer::where('bet_time', $nowTime)->first();
            $this->control($answer->number);
        }
    }
    public function control($number){
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        $ans = Answer::where('number', $number)->first();
        $maxId = null;
        $maxResult = -999999999;
        $count = 0;
        
        $havaMax = false;
        $newBetArr = [];
        $newBetIdArr = [];
        $betlist = Betlist::where('bet_number', $number)->get();
        $maxWin = 0;
        foreach($betlist as $e){
            in_array($e->user_id, $newBetIdArr);
            if(!in_array($e->user_id, $newBetIdArr)){
                array_push($newBetIdArr, $e->user_id);
            }
        }
        foreach($newBetIdArr as $user_id){
            $m = Betlist::where([['bet_number', $number], ['user_id', $user_id]])->sum("money");
            $r = Betlist::where([['bet_number', $number], ['user_id', $user_id]])->sum("result");
            if($maxResult < ($r - $m)){
                $maxResult = ($r - $m);
                $maxId = $user_id;
            }
            if($maxWin < $r){
                $maxWin = $r;
            }
        }
        
        $betArr = [];
        $maxItemId = 0;
        $maxResultOdds = 0;
        foreach(Betlist::where([['bet_number', $number], ['user_id', $maxId]])->get() as $item){
            $totalResult = 0;
            foreach(json_decode($item->bet_arr, true) as $arr){
                $totalResult = $totalResult + intval($arr['money']) * $arr['odds'];
            }
            if($totalResult > $maxResultOdds){
                $maxResultOdds = $totalResult;
                $maxItemId = $item->id;
            }
        }
        if($maxItemId==0){
            return;
        }
        $betArr = json_decode(Betlist::find($maxItemId)->bet_arr, true);
   
        $riskMaxArr = ["pos"=>[],"bs"=>[]];
        foreach($betArr as $el){
            $txt = $el['rank']."-".$el['content'];
            if($el['game'] == "大小單雙"){
                if(array_key_exists($txt, $riskMaxArr['bs'])){
                    $riskMaxArr['bs'][$txt] = intval($riskMaxArr['bs'][$txt]) + intval($el['money'])*$el['odds']; 
                }else{
                    $riskMaxArr['bs'][$txt] = intval($el['money'])*$el['odds'];
                }
            }elseif($el['game'] == "定位膽"){
                if(array_key_exists($txt, $riskMaxArr['pos'])){
                    $riskMaxArr['pos'][$txt] = intval($riskMaxArr['pos'][$txt]) + intval($el['money'])*$el['odds']; 
                }else{
                    $riskMaxArr['pos'][$txt] = intval($el['money'])*$el['odds'];
                }
            }
        }
        $maxText = "";
        $maxTextMoney = 0;
      
        foreach($riskMaxArr as $risk){
            foreach($risk as $key=>$r){
                if($maxTextMoney < $r){
                    $maxText = $key;
                    $maxTextMoney = $r;
                }
            }
        }
        $maxTextArr = explode("-", $maxText); 
        $gameType = $maxTextArr[1];
        $rankingArr = [1,2,3,4,5,6,7,8,9,10];
      
        if($gameType == "大" || $gameType == "小" || $gameType == "單" || $gameType == "雙" ){
            $bsArr = [];
            foreach(json_decode(json_encode($riskMaxArr), true)['bs'] as $key=>$bs ){
                array_push($bsArr , explode("-", $key)[1]);
            }
            while(true){
                $count++;
                shuffle($rankingArr);

                $winMoney = 0;
                foreach($betArr as $el){
                    if($el['game']=="大小單雙"){
                        if($rankingArr[$rankArr[$el['rank']]] >=6){
                            if(in_array("大", $bsArr)){
                                $winMoney = $winMoney + $el['money']*$el['odds'];
                            }
                        }elseif($rankingArr[$rankArr[$el['rank']]] <= 5){
                            if(in_array("小", $bsArr)){
                                $winMoney = $winMoney + $el['money']*$el['odds'];
                            }
                        }

                        if($rankingArr[$rankArr[$el['rank']]] %2 == 1){
                            if(in_array("單", $bsArr)){
                                $winMoney = $winMoney + $el['money']*$el['odds'];
                            }
                        }elseif($rankingArr[$rankArr[$el['rank']]] %2 == 0 ){
                            if(in_array("雙", $bsArr)){
                                $winMoney = $winMoney + $el['money']*$el['odds'];
                            }
                        }
                    }
                }
                if($winMoney == 0){
                    break;
                }else{
                    if($count<30){
                        continue;
                    }
                }

                if($count >=30){
                    if(count(array_unique($bsArr))==3){
                        if(!in_array("大", $bsArr)){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] >=6){
                                break;
                            }
                        }
                        if(!in_array("小", $bsArr)){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] <= 6){
                                break;
                            }
                        }
                        if(!in_array("單", $bsArr)){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] %2==1 ){
                                break;
                            }
                        }
                        if(!in_array("雙", $bsArr)){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] %2==0 ){
                                break;
                            }
                        }
                    }elseif(count(array_unique($bsArr))==2){
                        if($gameType == "大"){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] < 6){
                                break;
                            }
                        }elseif($gameType == "小"){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] > 5){
                                break;
                            }
                        }elseif($gameType == "單"){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] %2 ==0){
                                break;
                            }
                        }elseif($gameType == "雙"){
                            if($rankingArr[$rankArr[$maxTextArr[0]]] %2 ==1){
                                break;
                            }
                        } 
                    }
                   
                }
                if($count > 50){
                    break;
                }
                
            }
        }elseif(intval($gameType) >=1 && intval($gameType) <=10){
            while(true){
                $count++;
                shuffle($rankingArr);
                $winMoney = 0;
                foreach($betArr as $el){
                    if($el['game']=="定位膽"){
                        if($rankingArr[$rankArr[$el['rank']]] == intval($el['content'])){
                            $winMoney = $winMoney + $el['money']*$el['odds'];
                        }
                    }
                }
              
                if($winMoney <= 0){
                    break;
                }
                if($count > 50){
                    if($rankingArr[$rankArr[$maxTextArr[0]]] != intval($gameType)){
                        break;
                    }
                }
            }
        }
        
        $ranking = implode(",",$rankingArr);
        $ans->ranking = $ranking;
        $ans->save();
    }
    public function chkBet($t, $n, $betArr, $odds, $bsodds){
        $this->betMoney = intval($t);
        $this->chips = $n;
        $this->myDoller = intval($this->myDoller) - intval($t);
        
        DB::beginTransaction();

        try{
            $userMoney = Auth::user(); 
            $userMoney->money = $this->myDoller;
            $userMoney->save();
            $infoArr = ["飛機競速", ["定位膽",$odds, []],["大小單雙", $bsodds, []]];
            foreach($betArr as $bet){
                if($bet['beted'] && $bet['money'] > 0){
                    if($bet['game']=="定位膽"){
                        array_push($infoArr[1][2], []);
                        array_push($infoArr[1][2][count($infoArr[1][2])-1], $bet['rank'] , $bet['content'], (int)$bet['money']);
                    }elseif($bet['game']=="大小單雙"){
                        array_push($infoArr[2][2], []);
                        array_push($infoArr[2][2][count($infoArr[2][2])-1], $bet['rank'] , $bet['content'], (int)$bet['money']);
                    }
                }
            }
            $nowTime = date('Y-m-d H:i');
            $answer = Answer::where('bet_time', $nowTime)->first();
    
            array_push($infoArr, $answer->number, $answer->ranking);
            
            $win = $this->calcResult($betArr, $answer->ranking);
            $this->maxResult($betArr, $answer->number);
            if(date('s') < 37 && date('s') >=0){
                $betlist = new Betlist();
                $betlist->bet_number = $answer->number;
                $betlist->money = $t;
                $betlist->result = $win;
                $betlist->user_id = Auth::id();
                $betlist->chips = $n;
                $betlist->bet_info = json_encode($infoArr);
                $betlist->topline = Auth::user()->toponline;
                $betlist->game_type = 23;
                $betlist->bet_time = date("Y-m-d H:i:s");
                $betlist->bet_arr = json_encode($betArr);
                $betlist->beted_money = Auth::user()->money;
                $betlist->save();
                log::info($betArr);

            }else{
                throw new \Exception('error!!! time out!!!');
            }
            DB::commit();

            $this->dispatchBrowserEvent('betSuccess', ['bool'=>true]);
            return true;
        }catch(\Exception $e){
            log::info($e);
            DB::rollback();
            $this->dispatchBrowserEvent('betSuccess', ['bool'=>false]);
            return false;
        }
        
    }
    public function calcResult($betArr, $ans){
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        $winMoney = 0;
        $answer = explode(",", $ans);
        foreach($betArr as $bet){
            if($bet['game']=="定位膽" && $bet['beted']){
                if($answer[$rankArr[$bet['rank']]] == intval($bet['content'])){
                    $winMoney += ($bet['money'] * $bet['odds']);
                }
            }elseif($bet['game']=="大小單雙" && $bet['beted']){
                if($bet['content'] == "大" && $answer[$rankArr[$bet['rank']]] >= 6){
                    $winMoney += ($bet['money'] * $bet['odds']);
                }elseif($bet['content'] == "小" && $answer[$rankArr[$bet['rank']]] <= 5){
                    $winMoney += ($bet['money'] * $bet['odds']);
                }elseif($bet['content'] == "單" && ($answer[$rankArr[$bet['rank']]] %2) == 1){
                    $winMoney += ($bet['money'] * $bet['odds']);
                }elseif($bet['content'] == "雙" && ($answer[$rankArr[$bet['rank']]] %2) == 0){
                    $winMoney += ($bet['money'] * $bet['odds']);
                }
            }
        }
        return $winMoney;
    }
    
    public function maxResult($betArr, $number){
        $isset = Control::where([['number', $number], ['user_id', Auth::id()]])->count();
        if($isset > 0){ 
            $control = Control::where([['number', $number], ['user_id', Auth::id()]])->first();
            $newArr = json_decode($control->bet_arr, true);
            foreach($betArr as $bet){
                if($bet['game'] == '定位膽'){
                    if(array_key_exists($bet['rank']."-".$bet['content'],  $newArr)){
                        $newArr[$bet['rank']."-".$bet['content']] += intval($bet['money'] * $bet['odds']);
                    }else{
                        $newArr[$bet['rank']."-".$bet['content']] = intval($bet['money'] * $bet['odds']);
                    }
                }
            }
            $control->bet_arr = json_encode($newArr);
            $control->max_result = max($newArr);

            $control->save();
            
        }else{
            $newArr = [];
            foreach($betArr as $bet){
                if($bet['game'] == '定位膽' || true){
                    if(array_key_exists($bet['rank']."-".$bet['content'],  $newArr)){
                        $newArr[$bet['rank']."-".$bet['content']] += intval($bet['money'] * $bet['odds']);
                    }else{
                        $newArr[$bet['rank']."-".$bet['content']] = intval($bet['money'] * $bet['odds']);
                    }
                }
            }
            $control = new Control();
            $control->number = $number;
            $control->user_id = Auth::id();
            $control->bet_arr = json_encode($newArr);
            $control->max_result = max($newArr);
            $control->game_type = 23;
            $control->bet_time = date('Y-m-d H:i');

            $control->save();
        }
        
    }

    public function updateMyMoney(){
        $oldMoney = $this->myDoller;
        $newMoney = Auth::user()->money;
        $win = 0;
        $win =  ($newMoney - $oldMoney) > 0 ? $newMoney - $oldMoney : 0;
        $this->myDoller = Auth::user()->money;
        // $this->myDoller->save();
        // $m = $this->myDoller;
        $this->dispatchBrowserEvent('updateMyMoneyHtml', ['money'=>Auth::user()->money, 'win'=>$win]);
        // $this->betMoney = 0;
        // $this->chips = 0;
    }
    public function updateTrend(){
        $beforeTime = date('Y-m-d H:i', strtotime("-50 minute"));
        $nowTime = date('Y-m-d H:i', strtotime("-1 minute"));
        $answer = Answer::whereBetween('bet_time', [$beforeTime, $nowTime])->orderBy('id', 'DESC')->take(50)->get();
        $this->dispatchBrowserEvent('updateTrendFn', ['answer'=>$answer]);
    }
    public function watchStatu(){
        $gamestatus = GameStatu::where('gamenumber', 23)->first()->statu;
        $gameInfo = GameInfos::where('gamenumber', 23)->first();
        if($gamestatus == 0){
            $this->statu = 0;
        }else{
            $this->statu = Auth::user()->status;
        }
        $this->single_term = $gameInfo->single_term;
        $this->single_bet_limit = $gameInfo->single_bet_limit;
        $this->bs_single_term = $gameInfo->bs_single_term;
        $this->bs_single_bet_limit = $gameInfo->bs_single_bet_limit;
        $this->dispatchBrowserEvent('watchStatu', ['statu' => $this->statu]);
        $this->dispatchBrowserEvent('setBetLimit', ['single_term'=>$this->single_term, 'single_bet_limit'=>$this->single_bet_limit, 'bs_single_term'=>$this->bs_single_term, 'bs_single_bet_limit'=>$this->bs_single_bet_limit]);
    }
    public function store(){
        $date = date('d');
        $year = date('Y');
        $month = date('m');
        $timeArr = ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00"];
        $nowTime = 0;
        $twoHour = 1;
        $n = 1440;

        $minute = 0;
        $hour = 0;
        
        for($i=1;$i<=$n;$i++){
            $rankingArr = [1,2,3,4,5,6,7,8,9,10];
            shuffle($rankingArr);
            $ranking = implode(",",$rankingArr);
            
            if($minute >=60){
                $minute = 0;
                $hour++;
                $nowTime ++;
                $twoHour ++;
            }
            if($hour >= 24){
                $hour = 0;
            }
            if($minute < 10){
                $minuteStr = "0".$minute;
            }else{
                $minuteStr = $minute;
            }

            if($hour < 10){
                $hourStr = "0".$hour;
            }else{
                $hourStr = $hour;
            }
            $date_number = $year."-".$month."-".$date."-".$timeArr[$nowTime]."-".$timeArr[$twoHour];
            $number = "SR8294".$year.$month.$date.$hourStr.$minuteStr;
            $bet_time = $year."-".$month."-".$date." ".$hourStr.":".$minuteStr;
            $answer = new ModelsAnswer();
            $answer->number = $number;
            $answer->ranking = $ranking;
            $answer->date_number = $date_number;
            $answer->bet_time = $bet_time;
            $answer->save();

            $minute ++;
        }
    }   
    public function storeOneDay(){
        $date = date('d', strtotime("+1 day"));
        $year = date('Y');
        $month = date('m');


        $date = date('d', strtotime("+1 day"));
        $today = date('d');

        if(intval($date) != intval($today) + 1){
            $month = date('m' , strtotime("+1 day"));
            $mon = date('m');
            if(intval($month) != (intval($mon) + 1)){
                $year = date('Y', strtotime("+1 day"));
            }
        }

        $timeArr = ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00"];
        $nowTime = 0;
        $twoHour = 1;
        $n = 1440;

        $minute = 0;
        $hour = 0;
        
        for($i=1;$i<=$n;$i++){
            $rankingArr = [1,2,3,4,5,6,7,8,9,10];
            shuffle($rankingArr);
            $ranking = implode(",",$rankingArr);
            
            if($minute >=60){
                $minute = 0;
                $hour++;
                $nowTime ++;
                $twoHour ++;
            }
            if($hour >= 24){
                $hour = 0;
            }
            if($minute < 10){
                $minuteStr = "0".$minute;
            }else{
                $minuteStr = $minute;
            }

            if($hour < 10){
                $hourStr = "0".$hour;
            }else{
                $hourStr = $hour;
            }
            $date_number = $year."-".$month."-".$date."-".$timeArr[$nowTime]."-".$timeArr[$twoHour];
            $number = "SR8294".$year.$month.$date.$hourStr.$minuteStr;
            $bet_time = $year."-".$month."-".$date." ".$hourStr.":".$minuteStr;
            $answer = new ModelsAnswer();
            $answer->number = $number;
            $answer->ranking = $ranking;
            $answer->date_number = $date_number;
            $answer->bet_time = $bet_time;
            $answer->save();

            $minute ++;
        }
    }
    public function storeBefore(){
        $date = date('d', strtotime("-1 day"));
        $year = date('Y');
        $month = date('m');

        $date = date('d', strtotime("-1 day"));
        $today = date('d');

        if(intval($date) != intval($today) + 1){
            $month = date('m' , strtotime("-1 day"));
            $mon = date('m');
            if(intval($month) != (intval($mon) - 1)){
                $year = date('Y', strtotime("-1 day"));
            }
        }
        $timeArr = ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00"];
        $nowTime = 0;
        $twoHour = 1;
        $n = 1440;

        $minute = 0;
        $hour = 0;
        
        for($i=1;$i<=$n;$i++){
            $rankingArr = [1,2,3,4,5,6,7,8,9,10];
            shuffle($rankingArr);
            $ranking = implode(",",$rankingArr);
            
            if($minute >=60){
                $minute = 0;
                $hour++;
                $nowTime ++;
                $twoHour ++;
            }
            if($hour >= 24){
                $hour = 0;
            }
            if($minute < 10){
                $minuteStr = "0".$minute;
            }else{
                $minuteStr = $minute;
            }

            if($hour < 10){
                $hourStr = "0".$hour;
            }else{
                $hourStr = $hour;
            }
            $date_number = $year."-".$month."-".$date."-".$timeArr[$nowTime]."-".$timeArr[$twoHour];
            $number = "SR8294".$year.$month.$date.$hourStr.$minuteStr;
            $bet_time = $year."-".$month."-".$date." ".$hourStr.":".$minuteStr;
            $answer = new ModelsAnswer();
            $answer->number = $number;
            $answer->ranking = $ranking;
            $answer->date_number = $date_number;
            $answer->bet_time = $bet_time;
            $answer->save();

            $minute ++;
        }
    } 

    public function deleteTodayAnswer(){
        $start = Carbon::today()->startOfDay()->format('Y-m-d H:i');
        $end = Carbon::today()->endOfDay()->format('Y-m-d H:i');

        $answers = Answer::whereBetween('bet_time', [$start, $end])->delete();
    }
    public function deleteBeforeAnswer(){
        // $beforeDay = Carbon::today()->startOfDay()->subDays(1);
        $start = Carbon::today()->startOfDay()->subDays(1)->format('Y-m-d H:i');
        $end = Carbon::today()->endOfDay()->subDays(1)->format('Y-m-d H:i');

        $answers = Answer::whereBetween('bet_time', [$start, $end])->delete();
    }
    public function deleteAfterAnswer(){
        $start = Carbon::today()->startOfDay()->subDays(-1)->format('Y-m-d H:i');
        $end = Carbon::today()->endOfDay()->subDays(-1)->format('Y-m-d H:i');

        $answers = Answer::whereBetween('bet_time', [$start, $end])->delete();
    }
    public function removeBeforeAnswer(){
        $before = date("Y-m-d", strtotime("-2 day"));
        $answer = Answer::whereDate('created_at', '<=', $before)->delete();
    }
   
    public function initFn(){
        $this->watchStatu();
        $this->myDoller = Auth::user()->money;
        $beforeTime = date('Y-m-d H:i', strtotime("-4 minute"));
        $nowTime = date('Y-m-d H:i');
        $answer = Answer::whereBetween('bet_time', [$beforeTime, $nowTime])->get();
        $riskTime = date('Y-m-d H:i', strtotime("+1 minute"));
        $riskAnswer = Answer::where('bet_time',$riskTime)->get();
        $this->dispatchBrowserEvent('startRun', ['answer'=>$answer, 'riskAnswer'=>$riskAnswer]);


        $game_info = GameInfos::where('gamenumber', 23)->first();
        $this->odds = $game_info->odds;
        $this->bsodds = $game_info->bs_odds;
        $this->single_term = $game_info->single_term;
        $this->single_bet_limit = $game_info->single_bet_limit;
        $this->bs_single_term = $game_info->bs_single_term;
        $this->bs_single_bet_limit = $game_info->bs_single_bet_limit;
        $this->dispatchBrowserEvent('setOdds', ['odds'=>$this->odds, 'bsOdds'=>$this->bsodds]);
        $this->dispatchBrowserEvent('setBetLimit', ['single_term'=>$this->single_term, 'single_bet_limit'=>$this->single_bet_limit, 'bs_single_term'=>$this->bs_single_term, 'bs_single_bet_limit'=>$this->bs_single_bet_limit]);
    
        if(Auth::user()->point_lock === 1){
            $this->dispatchBrowserEvent('pointLockFn');
        }
        if(date('s') <= 37 && date('s') > 0){
            $now = Carbon::now();

            // 设置开始时间为当前时间的这一分钟的开始
            $start = $now->copy()->second(0);
    
            // 设置结束时间为当前时间的这一分钟的结束
            $end = $now->copy()->second(59);
            $initBetlist = Betlist::whereBetween('bet_time', [$start, $end])->get();
            $betArr = $initBetlist->pluck('bet_arr')->toArray();
            $this->dispatchBrowserEvent('initBetArrFn', ['betArr'=>$betArr]);
        }
        
    }
    public function render()
    {
        return view('livewire.airplane')->layout('livewire.layouts.game');
    }
}
