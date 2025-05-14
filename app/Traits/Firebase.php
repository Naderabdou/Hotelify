<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Firebase
{


    public $url       = "https://fcm.googleapis.com/v1/projects/liqaa-a7c10/messages:send";
    public $serverKey = '';

     public function sendFcmMessage($fcm_token,  $body , $title = null , $lang = 'ar')
    {


        $this->serverKey = $this->getServerToken();
      //  dd($this->serverKey);

      //  dd($this->serverKey);

        $data = [
            'message' => [
                "token" => $fcm_token,
                "notification" => [
                    "body" => $body,
                    "title" => $title


                ]
              //  'data' => "gtrgtgt",
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization: Bearer ' . $this->serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        // dd($result, $data);
        Log::info($result);
        if ($result === FALSE) {

            Log::info('Curl failed: ' . curl_error($ch));
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response

    }

    public function getServerToken()
    {
      //  $keyFilePath = storage_path('app/firebase/rakayb-202dd-firebase-adminsdk-h668p-fd2028f31b.json');
        $keyFilePath = base_path() . '/personal-trainer-firebase.json';
    //    dd($keyFilePath);
        $keyData = json_decode(file_get_contents($keyFilePath), true);

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $now = time();
        $claims = [
            'iss' => $keyData['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlClaims = $this->base64UrlEncode(json_encode($claims));

        $signatureInput = $base64UrlHeader . '.' . $base64UrlClaims;

        openssl_sign($signatureInput, $signature, $keyData['private_key'], 'sha256WithRSAEncryption');
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwt = $signatureInput . '.' . $base64UrlSignature;

        $postFields = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        $response = curl_exec($ch);
        if ($response === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        $responseData = json_decode($response, true);
        curl_close($ch);

        return $responseData['access_token'];
    }

    private function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
