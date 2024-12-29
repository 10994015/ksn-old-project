<?php

namespace App\Actions\Fortify;

use App\Models\PhoneCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public $randId;
    public $phone_number;
    public function create(array $input)
    {
        $this->randId = $input['randId'];
        $this->phone_number = $input['phone'];
       
        Validator::make($input, [
            'username' => ['required', 'string', 'min:4', 'max:10', 'unique:users'],
            'phone' => ['required', 'string', 'size:10', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'captcha'=>['required', 'captcha'],
            // 'email'=>['required','email'],
            // 'phone_verify'=>['required',function ($attribute, $value, $fail) { 
            //     if(PhoneCode::where('randId', $this->randId)->orderBy('id', 'DESC')->count() > 0){
            //         $phone = PhoneCode::where('randId', $this->randId)->orderBy('id', 'DESC')->first();
            //         $code = $phone->code;
            //         $phone_number = $phone->phone_number;
            //         if ($value != $code || $this->phone_number != $phone_number) { 
            //             $fail('驗證碼輸入錯誤！或是手機不相符'); 
            //         } 
            //     }else{
            //         $fail('驗證碼輸入錯誤！或是手機不相符'); 
            //     }
            // }],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ],[
            // 'phone_verify.required'=>'請輸入手機驗證碼',
            // 'email.required'=>'請輸入電子郵件',
            // 'email.email'=>'電子郵件格式錯誤',
            'captcha.required'=>'請輸入驗證碼',
            'captcha.captcha'=>'驗證碼錯誤',
            'phone.required'=>'請輸入手機',
            'phone.string'=>'手機為字串格式！',
            'phone.size'=>'手機為十碼',
            'phone.unique'=>'此手機已註冊過',
            'name.required'=>'請輸入姓名！',
            'name.string'=>'姓名為字串格式！',
            'username.required'=>'請輸入帳號！',
            'username.string'=>'帳號為字串格式！',
            'username.unique'=>'此帳號已有人使用！',
            'username.min'=>'帳號需大於4個字元',
            'username.max'=>'帳號需小於20個字元',
            'password.required'=>'請輸入密碼！',
            'password.confirmed'=>'確認密碼與密碼不相符！',
            'password.min'=>'密碼最少為6碼',
            'password.max'=>'密碼最多為20碼',
        ])->validate();
        $user_id = NULL;

        $remark = "";
        if($input['r_number'] != NULL){
            if(User::where('register_number', $input['r_number'])->count() >0){
                $user_id = User::where('register_number', $input['r_number'])->first()->id;
            }else{
                $user_id = User::where('highest_auth', true)->first()->id;
                $remark = "註冊時使用的代理網址無此代理";
            }
        }else{
            if(User::where('highest_auth', true)->count() > 0){
                $user_id = User::where('highest_auth', true)->first()->id;
            }else{
                $user_id = NULL;
            }
        }
        return User::create([
            'name' => $input['name'],
            // 'email' => $input['email'],
            'username' => $input['username'],
            'phone' => $input['phone'],
            'phone_verification' => true,
            'toponline'=>$user_id,
            'password' => Hash::make($input['password']),
            'remark'=>'為前五天的手機自動驗證',
            'remark'=>$remark,
        ]);
    }
}
