<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Tarit for standard Api Response
 * [
 * 'data',
 * 'message',
 * 'status'
 * ]
 */
trait SendNotificationTrait
{




    public $url = '';
    public $serverKey = '';

    public function sendFcmNotification($fcm_tokens,  $data, $lang = 'ar')
    {

        $this->url      = "https://fcm.googleapis.com/v1/projects/" . config('services.firebase.project_id') . "/messages:send";
        $this->serverKey = $this->getServerToken();
        $title = $data['name_' . $lang];
        $message = $data['body_' . $lang];



        //to send notification to multiple devices
        foreach ($fcm_tokens as $fcm_token) {
            //    dd($fcm_token);
            $data = [
                'message' => [
                    "token" => $fcm_token, // only for single device
                    "notification" => [
                        "title"    => $title,
                        "body"     => $message,
                    ],
                    'android' => [
                        'notification' => [
                            'sound' => 'azan1',
                            'channel_id' => 'channel_id',

                        ]
                    ]
                ]
            ];

            $encodedData = json_encode($data);
            $this->sendCurlRequest($encodedData);
        }
    }

    private function sendCurlRequest($encodedData)
    {

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
        // Disabling SSL Certificate support temporarily
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);
        // dd($result);
        Log::info($result);

        if ($result === FALSE) {
            $error = 'Curl failed: ' . curl_error($ch);
            Log::info($error);
            curl_close($ch);
            throw new \Exception($error);
        }
         dd($result);
        // Close connection
        curl_close($ch);
    }


    public function getServerToken()
    {

        // $keyFilePath = base_path() . '/firebase-credentials.json';
        // $keyData = json_decode(file_get_contents($keyFilePath), true);

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $now = time();
        $claims = [
            //'iss' => $keyData['client_email'],
            'iss' => config('services.firebase.client_email'),
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $base64UrlHeader = $this->base64UrlEncod(json_encode($header));
        $base64UrlClaims = $this->base64UrlEncod(json_encode($claims));

        $signatureInput = $base64UrlHeader . '.' . $base64UrlClaims;
        openssl_sign($signatureInput, $signature, config('services.firebase.private_key'), 'sha256WithRSAEncryption');
        $base64UrlSignature = $this->base64UrlEncod($signature);

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

    private function base64UrlEncod($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public function getName(array $data, $local = 'ar')
    {
        return $data['title_' . $local];
    }

    public function getBody(array $data, $local = 'ar')
    {
        // \dd($data['message_' . $local]);
        return $data['message_' . $local];
    }
}
