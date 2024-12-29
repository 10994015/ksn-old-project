<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'email_verified_at'=> now(),
            'password'=> bcrypt('admin123'),
            'utype'=>'ADM',
            'username'=>'admin',
            'phone'=>'0912345678',
            'phone_verification'=>true,
            'register_number'=>'pwMCPJV6KOMR7kxxPPJcdewTTtsskL',
            'highest_auth'=>true,
            'is_create_member'=>true,
        ],
      );
        User::create([
            'name'=>'一個人的武林',
            'email'=>'control@gmail.com',
            'email_verified_at'=> now(),
            'password'=> bcrypt('control123'),
            'utype'=>'COT',
            'username'=>'control',
            'phone'=>'0912345679',
            'phone_verification'=>true,
        ]);
    }
}
