<?php

namespace App\Listeners;

use App\Models\LoginRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->update([
            'last_login_time' => now(),
            'last_login_ip' => request()->getClientIp(),
            'status'=>1
        ]);
        $login_record = new LoginRecord();
        $login_record->username = $event->user->username;
        $login_record->login_time = now();
        $login_record->login_ip = request()->getClientIp();
        $login_record->save();
    }
}
