<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    
    public function submitForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);
    
        // Save the message in the database
        $emailMessage = Email::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
    
        // Send email notification
        Mail::send('emails.contactemail', ['emailMessage' => $emailMessage], function ($mail) use ($emailMessage) {
            $mail->to('uminduchethiya@gmail.com') // Replace with your admin email
                 ->subject('New Contact Message from ' . $emailMessage->name);
        });
    
        // Redirect back with success message
        return redirect()->back()->with('status', 'success')->with('message', 'Message sent successfully!');
    }
    
}
