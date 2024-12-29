<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\Control;
use App\Models\GameInfos;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CronTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        sleep(37);
        
        $gameinfo = GameInfos::where('gamenumber', '23')->first();

        if($gameinfo->mode === 1){
            $nowTime = date('Y-m-d H:i');
            $answer = Answer::where('bet_time', $nowTime)->first();

            if(Betlist::where('bet_number', $answer->number)->count() <=0) return;
            
            // $this->control($answer->number);
            $this->controls($answer->number);
        }

    }
    public function controls($number){
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        $maxId = null;

        $maxResult = Control::where('number', $number)->max('max_result');
        $maxId = Control::where(['number'=>$number, 'max_result'=>$maxResult])->first()->user_id;

        $betlist = Betlist::where(['bet_number'=>$number, 'user_id'=>$maxId])->get();
        $maxUserBetArr = [];
        foreach($betlist as $bet){
            $maxUserBetArr = array_merge($maxUserBetArr, json_decode($bet->bet_arr, true));
        }

        $count = 0;
        $rankingArr = [1,2,3,4,5,6,7,8,9,10];
        while(true){
            $count++;
            $win = 0;

            shuffle($rankingArr);
            foreach($maxUserBetArr as $arr ){
                if($arr['game'] === "定位膽"){
                    if($rankingArr[$rankArr[$arr['rank']]] == intval($arr['content'])){
                        $win += intval($arr['money'] * $arr['odds']);
                    }
                }else if($arr['game'] === '大小單雙'){
                    if($arr['content'] == '大'){
                        if($rankingArr[$rankArr[$arr['rank']]] >= 6){
                            $win += $arr['money'] * $arr['odds'];
                        }
                    }elseif($arr['content'] == '小'){
                        if($rankingArr[$rankArr[$arr['rank']]] <= 5){
                            $win += $arr['money'] * $arr['odds'];
                        }
                    }elseif($arr['content'] == '單'){
                        if($rankingArr[$rankArr[$arr['rank']]] % 2 == 1){
                            $win += $arr['money'] * $arr['odds'];
                        }
                    }elseif($arr['content'] == '雙'){
                        if($rankingArr[$rankArr[$arr['rank']]] % 2 == 0){
                            $win += $arr['money'] * $arr['odds'];
                        }
                    }
                }
            }

            if($win == 0){
                break;
            }else{
                if($count<=30){
                    continue;
                }
            }
            if($count > 30 ){
                if($win <= $maxResult /3){
                    break;
                }
            }
            if($count > 40 ){
                if($win <= $maxResult /2){
                    break;
                }
            }
            if($count > 50 ){
                if($win <= $maxResult){
                    break;
                }
            }
            if($count>60){
                break;
            }
        }
        $ans = Answer::where('number', $number)->first();
        $ranking = implode(",",$rankingArr);
        $ans->ranking = $ranking;
        $ans->save();

    }
    public function control($number){
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        $ans = Answer::where('number', $number)->first();
        $maxId = null;
        $maxResult = -999999999;
        $count = 0;
     
        $newBetIdArr = [];
        $betlist = Betlist::where('bet_number', $number)->get();
        if(count($betlist) <= 0) return;
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


        return $winMoney;

    }


   
}
