<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Models\PhoneCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class PhoneCodeSendController extends Controller
{
    public function send(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://send.api.mailtrap.io/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"from":{"email":"mailtrap@stvecommerceita.online","name":"Mailtrap Test"},"to":[{"email":"dustinblocks0@gmail.com"}],"subject":"You are awesome!","text":"Congrats for sending test email with Mailtrap!","category":"Integration Test"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer a4c2e4ad09cea1fd8fe50eb11efb8cbf',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function sendMail(Request $req){
        $name = "哈哈";
        $email = "123";
        $title = "安安安";
        $content = "黑ㄏ";
        // $name,$email,$title,$content
        $subject = "=?UTF-8?B?".base64_encode('九霄空間設計訊息通知')."?=";
        $text = '姓名:'.$name.'<br>'
                    .'發送者信箱:'.$email
                    .'主旨:'.$title
                    .'訊息:<br>'.$content;


        $header = "From: a0938599191@gmail.com\r\n";
        $header .= "Content-type: text/html; charset=utf8";

        //mail(收件者,信件主旨,信件內容,信件檔頭資訊)
        $result = mail('a0938599191@gmail.com', $subject, $text, $header);
        echo $result;
        return $result;
    }
    public function emailsend(Request $req){
        $code = rand(1000, 9999);
        $data = ['user' => $req->email];
        Mail::send('register', ['user' => $data], function ($m) use ($data) {
            $m->from('a0938599191@gmail.com', 'Your Application');

            $m->to('a0938599191@gmail.com', '安安')->subject('Your Reminder!');
        });

        // Mail::send('emails.reminder', $data, function ($message) use ($data) {
        //     $message->from(ENV('MAIL_USERNAME', 'dustinblocks0@gmail.com'), $data['email']);
        //     $message->to('a0938599191@gmail.com', 'a0938599191@gmail.com')->subject('Feedback Mail');
        // });

        // Mail::send('register', ['user' => $data], function ($m) use ($data) {
        //     $m->from('hello@app.com', 'Your Application');

        //     $m->to('a0938599191@gmail.com', '安安')->subject('Your Reminder!');
        // });

        return ['message'=>$req->email];
    }
    public function sendCode(Request $req){
        $code = rand(1000, 9999);
        $phone ="886" . substr($req->phone, 1);

        // $basic  = new \Vonage\Client\Credentials\Basic(env('PHONE_API_KEY'), env('PHONE_API_KEY_PASSWORD'));
        // $client = new \Vonage\Client($basic);
        $basic  = new \Vonage\Client\Credentials\Basic("2cae787f", "v6Wudnvu28zMdMy3");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phone, 'KSN E-commerce', 'KSN電商訊息:您的驗證碼為 '.$code.' 請於兩分鐘內完成驗證')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            $randId = rand(100000000,9999999999) . date("YmdHis");
            $pc = new PhoneCode();
            $pc->code = $code;
            $pc->randId = $randId;
            $pc->phone_number = $req->phone;
            $pc->save();
            return ['randid'=>$randId];
        }
        return ['error'=>'Failed to send, please check the server or your vonage code or insufficient balance!'];
    }
}
