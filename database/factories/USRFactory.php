<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class USRFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * 
     */

     protected $model = User::class;
     
    
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
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
            'is_cteate_member'=>0,
            'data_auth'=>0,
            'islogin'=>0,
        ];
    }

    
}
