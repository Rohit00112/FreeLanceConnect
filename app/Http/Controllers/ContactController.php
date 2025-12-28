<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;


class ContactController extends Controller
{
    public function index()
    {
        return view('ClientsContact.contact');
    }
    public function submit(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Save the contact form submission to the database
Contact::create($validatedData);

        // Process the contact form submission
        Mail::send([], [], function ($message) use ($validatedData) {
            $message->to('kritikac206@gmail.com')
                    ->subject('New Contact Form Submission')
                    ->html('
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; }
                                .container { width: 100%; padding: 20px; }
                                .header { background-color:rgb(182, 59, 234); color: white; padding: 10px; text-align: center; }
                                .content { margin-top: 20px; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
                                th { background-color: #f2f2f2; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="header">
                                    <h2>Contact Form Submission</h2>
                                </div>
                                <div class="content">
                                    <table>
                                        <tr><th>Name</th><td>' . $validatedData['name'] . '</td></tr>
                                        <tr><th>Email</th><td>' . $validatedData['email'] . '</td></tr>
                                        <tr><th>Message</th><td>' . $validatedData['message'] . '</td></tr>
                                    </table>
                                </div>
                            </div>
                        </body>
                        </html>');
        });

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
