<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Betlist;
use App\Models\GameStatu;
use App\Models\StorePointRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
class AirplaneTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_chk_bet()
    {
        
        GameStatu::create([
            'name'=>'60秒急速飛機',
            'gamenumber'=>23,
            'statu'=>true,
            'maintenance'=>false
        ]);
        $user = User::create([
            'name'=>'123',
            'password'=>bcrypt('password123'),
            'money'=>1000,
            'total_money'=>1000,
            'username'=>'pdf123456',
            'phone'=>'0988778899',
            'phone_verification'=>true,
            'status'=>true,
            'toponline'=>1,
            'data_auth'=>true
        ]);
        StorePointRecord::create([
            'money'=>1000,
            'store'=>1,
            'store_type'=>2,
            'order_number'=>'123456',
            'username'=>'pdf123456',
            'status'=>1,
            'proxy_id'=>1,
            'member_id'=>$user->id,
            'is_first'=>1
        ]);
        $this->post('/login', [
            'username'=>'pdf123456',
            'password'=>'password123'
        ]);
        $response = $this->actingAs($user)->get('/airplane');

        $response->assertStatus(200);
        
    }
}
