<?php

namespace App\Models;


use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
        'expire_at',
    ];

    public function sendOtp($receiverNumber){
        $message = 'Login Otp is ' .$this->otp;
        try{
            $account_id = getenv('TWILIO_ACCOUNT_SID');
            $auth_token = getenv('TWILIO_AUTH_TOKEN');
            $twilio_number = getenv('TWILIO_NO');
            $client = new Client($account_id, $auth_token);
            $mmss=$client->messages->create($receiverNumber,[
                'From'=>$twilio_number,
                'Body'=>$message
            ]);
                info("SMS send successfully");
        }catch(Exception $e){
            $e->getMessage();
        }
    }
}
