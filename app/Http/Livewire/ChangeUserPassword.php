<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangeUserPassword extends Component
{
    public $old_password;
    public $password;
    public $password_confirmed;
    public function updatePassword(){
        $this->validate([
            'old_password' => ['required', 'string', 'min:8',function ($attribute, $value, $fail) { 
                if (! Hash::check($value, Auth::user()->password)) { 
                    $fail('原密碼輸入錯誤'); 
                } 
            }], 
            'password'=>['required', 'string', 'min:8', function ($attribute, $value, $fail) { 
                if ($this->password !== $this->password_confirmed) { 
                    $fail('確認密碼不相符'); 
                } 
            }],
        ]);
        $user = User::find(Auth::id());
        if($user){
            $user->password = Hash::make($this->password);
            $user->save();
            session()->flash('success', '密碼修改成功！');
            $this->old_password = "";
            $this->password = "";
            $this->password_confirmed = "";
        }
    }
    public function render()
    {
        return view('livewire.change-user-password')->layout('livewire.layouts.base');
    }
}
