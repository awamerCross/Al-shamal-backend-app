<?php


namespace App\Libraries;


class Firebase
{

    private $header = ['Authorization:key=AAAA9Bg2ROU:APA91bE6ScdwLdmiE8Xn67GnTzhg88caiL-Ha8W8UhZclwVMvm-FmINNdFFWvyRQvyD9ce8CYbDamfq64GD0UyS0wFg5mqFRpkziGTeUawU9-S6YWKtDBwNXSef9dsz9TFZ_JAnX75hs', 'Content-Type:Application/json',];

    #  const SERVER_API_KEY = '';
    public function sendNotify($tokens, $data)
    {


        $notification = [
            "title"                 => $data['title'],
            "body"                  => $data['body'],
            "type"                  => $data['type'],
            "sound"                 => "default",
            "badge"                 => "1",

        ];

        $extraNotificationData = [
            "title"                => $data['title'],
            "body"                 => $data['body'],
            "sound"                => "default",
            "badge"                => "1",
        ];

        $fcmNotification           = [
            'registration_ids'     => $tokens, //multiple token array
            "priority"             => "High",
            "notification"         => $notification,
            "data"                 => $extraNotificationData,
        ];


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($fcmNotification),
            CURLOPT_HTTPHEADER     => $this->header
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

        return $response;
    }

}
