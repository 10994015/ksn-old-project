<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameInfos;
use App\Models\GameStatu;
use App\Models\Gametype;
use App\Models\LoginFail;
use Illuminate\Database\Seeder;

class GameTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gametype::create(['id'=>1,'typename'=>'官方彩票',]);
        Gametype::create(['id'=>2,'typename'=>'自開彩票',]);
        Gametype::create(['id'=>3,'typename'=>'賭場遊戲',]);
        Game::create(['name'=>'60秒急速賽車','gametype_id'=>2]);
        Game::create(['name'=>'60秒急速賽馬','gametype_id'=>2]);
        Game::create(['name'=>'60秒急速飛機','gametype_id'=>2]);
        Game::create(['name'=>'龍虎','gametype_id'=>3]);
        GameStatu::create(['name'=>'60秒急速飛機','gamenumber'=>23, 'statu'=>1, 'maintenance'=>0]);
        LoginFail::create(['id'=>1, 'failed'=>0]);
        GameInfos::create(['gamenumber'=>23,'answer_datebase'=>'answer', 'game_name'=>'60秒急速飛機', 'odds'=>9.8, 'single_term'=>100000, 'single_bet_limit'=>100000, 'bs_odds'=>1.96, 'bs_single_term'=>100000, 'bs_single_bet_limit'=>100000, 'brfore'=>1, 'after'=>0, 'mode'=>0, 'model'=>0]);
    }
}
