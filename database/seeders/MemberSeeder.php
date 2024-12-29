<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i=0;$i<300;$i++){
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'money'=>100000,
                'point_lock'=>false,
                'total_money'=>100000,
                'handle_money'=>0,
                'utype'=>'USR',
                'username'=>Str::random(rand(8, 12)),
                'phone'=>strval(random_int(pow(10, 8), pow(10, 9) - 1)),
                'phone_verification'=>1,
                'toponline'=>1,
                'highest_auth'=>0,
                'issub'=>0,
                'is_create_member'=>0,
                'data_auth'=>0,
                'islogin'=>0,
            ]);
        }
        
    }
}
