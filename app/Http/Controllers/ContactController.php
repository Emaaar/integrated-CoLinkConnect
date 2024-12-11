<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = env('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = env('SMTP_PORT');

            // Recipients
            $mail->setFrom($request->email, $request->name);
            $mail->addAddress('arlonielockon@gmail.com', 'CoLink Admin'); // Replace with actual admin email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission: ' . $request->subject;
            $mail->Body    = "
                <h1>New Contact Form Submission</h1>
                <p><strong>Name:</strong> {$request->name}</p>
                <p><strong>Email:</strong> {$request->email}</p>
                <p><strong>Subject:</strong> {$request->subject}</p>
                <p><strong>Message:</strong></p>
                <p>{$request->message}</p>
            ";

            $mail->send();

            return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
        } catch (Exception $e) {
            return redirect()->route('contact')->with('error', 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }
}
