<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ChatController extends Controller
{
    public function adminChat()
    {
        $users = User::select('client_id', 'user_email', 'firstname', 'lastname')->get();
        return view('chat.admin', compact('users'));
    }

    public function index()
    {
        $user = Auth::user();
        $messages = Chat::where(function($query) use ($user) {
                        $query->where('sender_email', $user->user_email)
                              ->orWhere('receiver_email', $user->user_email);
                    })
                    ->where('deleted_by_user', false)
                    ->orderBy('timestamp', 'asc')
                    ->get();

        return view('chat.index', compact('messages'));
    }

    public function getChatHistory($userEmail)
    {
        $messages = Chat::where(function($query) use ($userEmail) {
            $query->where(function($q) use ($userEmail) {
                $q->where('sender_email', $userEmail)
                  ->orWhere('receiver_email', $userEmail);
            });
        })
        ->where(function($query) {
            if (session()->has('admin_email')) {
                return $query;
            }
            return $query->where('deleted_by_user', false);
        })
        ->orderBy('chat_id', 'asc')
        ->get();

        return response()->json($messages);
    }

    public function adminSendMessage(Request $request)
    {
        $message = Chat::create([
            'timestamp' => now(),
            'sender_email' => 'arlonielockon@gmail.com',
            'receiver_email' => $request->receiver_email,
            'message' => $request->message,
            'deleted_by_user' => false
        ]);

        $this->sendEmailNotification($request->receiver_email, $request->message, 'Admin');

        return response()->json(['status' => 'success', 'message' => 'Message sent']);
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = Chat::create([
            'timestamp' => now(),
            'sender_email' => $user->user_email,
            'receiver_email' => 'arlonielockon@gmail.com',
            'message' => $request->message,
            'client_id' => $user->client_id,
            'deleted_by_user' => false
        ]);

        $this->sendEmailNotification('arlonielockon@gmail.com', $request->message, $user->firstname);

        return response()->json(['status' => 'success', 'message' => 'Message sent']);
    }

    private function sendEmailNotification($to, $messageContent, $senderName)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = getenv('SMTP_PORT');

            $mail->setFrom('arlonielockon@gmail.com', 'CoLink Chat');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = 'New Chat Message from ' . $senderName . ' (Chat Support)';
            $mail->Body = "You have received a new message from {$senderName}:<br><br>{$messageContent}";

            $mail->send();
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    public function deleteConversation(Request $request)
    {
        $user = Auth::user();

        Chat::where(function($query) use ($user) {
            $query->where('sender_email', $user->user_email)
                  ->orWhere('receiver_email', $user->user_email);
        })->update(['deleted_by_user' => true]);

        return response()->json(['status' => 'success']);
    }
}

