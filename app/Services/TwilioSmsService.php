<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioSmsService
{
    protected $twilio;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $this->twilio = new Client($sid, $authToken);
    }

  
    public function sendSms(string $to, string $body): array
    {
        try {
            $from = env('TWILIO_PHONE_NUMBER'); 
            // $message = $this->twilio->messages->create($to, [
            //     'from' => $from,
            //     'body' => $body,
            // ]);

            // return [
            //     'success' => true,
            //     'messageSid' => $message->sid,
            //     'status' => $message->status,
            // ];
            return [
                'success' => true,
                'messageSid' => '',
                'status' => '',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
