<?php

namespace App\Console\Commands;

use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:answer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增答案';

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
        }
        try{
            if($isOneDayAns==0){
                $this->storeOneDay();
            }
        }catch (\Exception $e) {
            $this->deleteAfterAnswer();
            $this->storeOneDay();
        }

        if(intval(date("H"))==0 && intval(date("i")) <= 5){
            $isBeforeAns = Answer::where('bet_time', date('Y-m-d H:i', strtotime("-1 day")))->count();
            try{
                if($isBeforeAns === 0){
                    $this->storeBefore();
                }
            }catch (\Exception $e) {
                $this->deleteBeforeAnswer();
                $this->storeBefore();
            }
        }
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
            $answer = new Answer();
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
            $answer = new Answer();
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
}
