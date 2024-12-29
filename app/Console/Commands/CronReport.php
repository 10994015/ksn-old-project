<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\Errorlog;
use App\Models\Log as ModelsLog;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CronReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:report';

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
        sleep(6);
        $startTime = microtime(true);
        $date = date("Y-m-d H:i");
        $answer = Answer::select(['ranking', 'number'])->where('bet_time', $date)->first();

        if($answer){
            $this->reportChkFn($answer);
        }
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) ;

    }

    public function reportChkFn($answer){
        $newArr = [];
        $ranking = $answer->ranking;
        $number = $answer->number;
        $ans = explode(",", $ranking);
        $betList = Betlist::where('bet_number',$number)->get();
        if($betList->count() <= 0) return;
        $rankArr = ["冠軍"=>0, "亞軍"=>1, "季軍"=>2, "第四名"=>3, "第五名"=>4, "第六名"=>5, "第七名"=>6, "第八名"=>7, "第九名"=>8, "第十名"=>9 ];
        DB::beginTransaction();
        try{
            foreach($betList as $bet){
                $result = 0;
                if(true){
                    $arr = json_decode($bet->bet_arr, true);
                    
                    foreach($arr as $item){
                        if(trim($item['game'])=="定位膽"){
                            if($ans[$rankArr[$item['rank']]] == intval($item['content'])){
                                $result = $result + (int)$item['money']*(float)$item['odds'];
                            }else{
                                $log = new ModelsLog();
                                $log->log = "不是大小單雙(" . $bet->bet_number;
                                $log->save();
                            }
                        }elseif(trim($item['game'])=="大小單雙"){
                            if(trim($item['content'])=="大"){
                                if((int)$ans[$rankArr[$item['rank']]] >= 6){
                                    $result = $result + (int)$item['money']*(float)$item['odds'];
                                }
                            }
                            elseif(trim($item['content'])=="小"){
                                if((int)$ans[$rankArr[$item['rank']]] <= 5){
                                    $result = $result + (int)$item['money']*(float)$item['odds'];
                                }
                            }
                            elseif(trim($item['content'])=="單"){
                                if((int)$ans[$rankArr[$item['rank']]]%2 == 1){
                                    $result = $result + (int)$item['money']*(float)$item['odds'];
                                }
                            }
                            elseif(trim($item['content'])=="雙"){
                                if((int)$ans[$rankArr[$item['rank']]]%2 == 0){
                                    $result = $result + (int)$item['money']*(float)$item['odds'];
                                }
                            }else{
                                $log = new ModelsLog();
                                $log->log = "不是大小單雙(" . $bet->bet_number;
                                $log->save();
                            }
                        }
                    }
                    $bet->final = $result;
                    $bet->save();
                    
                    $user = User::find($bet->user_id);
                    $storageMoney = (int)$user->money + (int)$result;
                    $user->money = $storageMoney;
                    $isOk = $user->save();
                    array_push($newArr, $isOk);

                    if(!$isOk){
                        $err = new Errorlog();
                        $err->user_id = $bet->user_id;
                        $err->bet_no = $bet->number;
                        $err->origin_money = $user->money;
                        $err->new_money = $storageMoney;
                        $err->win_money = $bet->final;
                        $err->save();
                    }
                    $report = new Report();
                    $report->user_id = $bet->user_id;
                    $report->bet_money = $bet->money;
                    $report->result = $bet->final;
                    $report->topline = User::select('id')->find($bet->topline)->id;
                    $report->game_type = 23;
                    $report->bet_number = $number;
                    $report->save();
                    
                    if(($user->money != $storageMoney)){
                        $user->money = $storageMoney;
                        $user->save();
                    }else{
                        $bet->ok_store_money = 1;
                        $bet->save();
                    }
                }
            }
            DB::commit();
        }catch(\Exception $e){
            $log = new ModelsLog();
            $log->log = $e;
            $log->save();
            DB::rollback();
        }
    }
}
