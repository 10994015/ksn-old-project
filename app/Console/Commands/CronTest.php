<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CronTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:test';

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

        for($n=9;$n<=615;$n++){
            $total_num = 3;
            $bet1 = rand(1,10) * 10;
            $bet2 = rand(1,10) * 10;
            $bet3 = rand(1,10) * 10;
            $total_bet = $bet1 + $bet2 + $bet3;
            $odds = 9.8;
            $bsOdds = 1.96;
            $rankArr = ['01','02','03','04','05','06','07','08','09','10'];
            $betArr = [
                [
                    'id'=>1,
                    'game'=>'定位膽',
                    'rank'=>'冠軍',
                    'beted'=>true,
                    'money'=>$bet1,
                    'odds'=>$odds,
                    'content'=>$rankArr[rand(0,9)],
                ],
                [
                    'id'=>2,
                    'game'=>'定位膽',
                    'rank'=>'冠軍',
                    'beted'=>true,
                    'money'=>$bet2,
                    'odds'=>$odds,
                    'content'=>$rankArr[rand(0,9)],
                ],
                [
                    'id'=>3,
                    'game'=>'定位膽',
                    'rank'=>'冠軍',
                    'beted'=>true,
                    'money'=>$bet3,
                    'odds'=>$odds,
                    'content'=>$rankArr[rand(0,9)],
                ],
            ];


            $this->chkBet($total_bet, $total_num, $betArr, $odds, $bsOdds, $n);
        }
    }

    public function chkBet($t, $n, $betArr, $odds, $bsodds ,$member_id){
        if(User::where('id', $member_id)->count() <=0) return;
       
        $userMoney = User::where('id', $member_id)->first(); 
        $userMoney->money = intval($userMoney->money) - intval($t);
        $userMoney->save();


        $infoArr = ["飛機競速", ["定位膽",$odds, []],["大小單雙", $bsodds, []]];
        foreach($betArr as $bet){
            if($bet['beted'] && $bet['money'] > 0){
                if($bet['game']=="定位膽"){
                    array_push($infoArr[1][2], []);
                    array_push($infoArr[1][2][count($infoArr[1][2])-1], $bet['rank'] , $bet['content'], $bet['money']);
                }elseif($bet['game']=="大小單雙"){
                    array_push($infoArr[2][2], []);
                    array_push($infoArr[2][2][count($infoArr[2][2])-1], $bet['rank'] , $bet['content'], $bet['money']);
                }
            }
        }
        $nowTime = date('Y-m-d H:i');
        $answer = Answer::where('bet_time', $nowTime)->first();

        array_push($infoArr, $answer->number, $answer->ranking);
        
        $win = $this->calcResult($betArr, $answer->ranking);
        if(date('s') <=37 && date('s') >=0){
            $betlist = new Betlist();
            $betlist->bet_number = $answer->number;
            $betlist->money = $t;
            $betlist->result = $win;
            $betlist->user_id = $userMoney->id;
            $betlist->chips = $n;
            $betlist->bet_info = json_encode($infoArr);
            $betlist->topline = $userMoney->toponline;
            $betlist->game_type = 23;
            $betlist->bet_time = date("Y-m-d H:i:s");
            $betlist->bet_arr = json_encode($betArr);
            $betlist->save();
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
}
