<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Exception;
use App\Services\TwilioSmsService;


class SMSController extends Controller
{

    private $smsService;

   

    public function sendSMS(Request $request,TwilioSmsService $smsService)
    {
        try {
            // Validate incoming request
            $data = $request->validate([
                'contactNumber' => 'required|string',
                'message' => 'required|string|max:160',
            ]);

            $countryCode = '+94'; // Default country code for Sri Lanka
            $userContactNumber = $data['contactNumber'];

            // Ensure the contact number starts with the correct country code
            if (!str_starts_with($userContactNumber, $countryCode)) {
                $userContactNumber = $countryCode . ltrim($userContactNumber, '0');
            }

            // Send SMS
            $smsResponse = $smsService->sendSms($userContactNumber, $data['message']);

            if (!$smsResponse['success']) {
                throw new Exception('Failed to send SMS: ' . $smsResponse['error']);
            }

            return response()->json([
                'success' => true,
                'message' => 'SMS sent successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
