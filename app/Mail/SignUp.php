<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->code = $data['code'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ooxx@gmail.com', 'KSN註冊驗證')
        ->subject('KSN電商註冊驗證信')->view('SignUpView');

        // return $this->subject('Mail subject')->view('SignUpView');
        // return $this->view('SignUpView');
    }
}
