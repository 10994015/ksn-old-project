<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function reportChkFn(){


        $answer = Answer::where('bet_time', '2023-07-06 23:59')->first();
        $ranking = $answer->ranking;
        $number = $answer->number;
        $ans = explode(",", $ranking);
        $betList = Betlist::where('bet_number',$number)->get();
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        foreach($betList as $bet){
            $result = 0;
            if($bet->final == null){
                $arr = json_decode($bet->bet_arr, true);
                
                foreach($arr as $item){
                    if($item['game']=="定位膽" && $item['beted']){
                        if($ans[$rankArr[$item['rank']]] == intval($item['content'])){
                            $result = $result + $item['money']*$item['odds'];
                        }
                    }elseif($item['game']=="大小單雙" && $item['beted']){
                        if($item['content']=="大" && $ans[$rankArr[$item['rank']]] >= 6){
                            $result = $result + $item['money']*$item['odds'];
                        }elseif($item['content']=="小" && $ans[$rankArr[$item['rank']]] <= 5){
                            $result = $result + $item['money']*$item['odds'];
                        }elseif($item['content']=="單" && $ans[$rankArr[$item['rank']]]%2 == 1){
                            $result = $result + $item['money']*$item['odds'];
                        }elseif($item['content']=="雙" && $ans[$rankArr[$item['rank']]]%2 == 0){
                            $result = $result + $item['money']*$item['odds'];
                        }
                    }
                }
                $bet->final = $result;
                
                $bet->save();
                
                $user = User::find($bet->user_id);
                $storageMoney = $user->money + $bet->final;
                $user->money += $bet->final;
                $isOk = $user->save();
                
                $report = new Report();
                $report->user_id = $bet->user_id;
                $report->bet_money = $bet->money;
                $report->result = $bet->final;
                $report->topline = User::find($bet->topline)->id;
                $report->game_type = 23;
                $report->bet_number = $number;
                $report->save();

                $user = User::find($bet->user_id);
                if($user->money != $storageMoney || $isOk){
                    $user->money = $storageMoney;
                    $isOk = $user->save();
                }
                $user = User::find($bet->user_id);
                if($user->money == $storageMoney){
                    $bet->ok_store_money = 1;
                    $bet->save();
                }
            }
        }

    
       
    }
}
