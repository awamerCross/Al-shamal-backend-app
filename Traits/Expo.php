<?php

namespace App\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;

trait  Expo
{
    public function sendExpoNotify($user , $data){
        foreach ($user->devices as $token){
            try{
                $interestDetails    = ["$token->device_id", $token->device_id];
                $expo               = \ExponentPhpSDK\Expo::normalSetup();
                $expo->subscribe($interestDetails[0], $interestDetails[1]);
                $notification       = [
                    'title'                  => $data['title_'.lang()],
                    'body'                   => $data['message_'.lang()] ,
                    'data'                   => json_encode($data['data']),
                    'sound'                  => 'default',
                ];
                $expo->notify($interestDetails[0], $notification);
            }catch (Throwable $e){
                return ; 
            }
        }
    }
}

