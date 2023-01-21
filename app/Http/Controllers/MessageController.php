<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getAllUserMessages() {
        $user = Auth::user();

        if (!$user) {
            return response()->json([], 403);
        }

        $messages = Message::where('from_id', $user->id)->orWhere('to_id', $user->id)->orderBy('created_at', 'desc')->get();

        $response = (object)[];
        $response->emails = [];
        $inboxCounter = 0;
        $draftCounter = 0;
        $spamCounter = 0;

        foreach ($messages as $message) {
            $parsedMessage = (object)[];
            $parsedMessage->id = $message->id;

            $fromUser = User::findOrFail($message->from_id);
            $parsedMessage->from = (object)[];
            $parsedMessage->from->email = $fromUser->email;
            $parsedMessage->from->name = $fromUser->fullName;
            $parsedMessage->from->avatar = '/images/'.$fromUser->avatar;

            $toActualUser = User::findOrFail($message->to_id);
            $parsedMessage->to = [];
            $toUser = (object)[];
            $toUser->name = $toActualUser->fullName;
            $toUser->email = $toActualUser->email;
            array_push($parsedMessage->to, $toUser);

            $parsedMessage->subject = $message->subject;
            $parsedMessage->message = $message->message;
            $parsedMessage->isStarred = $message->isStarred;
            $parsedMessage->time = $message->created_at;
            $parsedMessage->isRead = $message->isRead;
            $parsedMessage->folder = $message->folder;

            switch ($message->folder) {
                case 'inbox': ++$inboxCounter; break;
                case 'spam': ++$spamCounter; break;
                case 'draft': ++$draftCounter; break;
            }

            // Other attributes not yet supported, so empty array is returned
            $parsedMessage->labels = [];
            $parsedMessage->attachments = [];
            $parsedMessage->replies = [];
            $parsedMessage->cc = [];
            $parsedMessage->bcc = [];

            array_push($response->emails, $parsedMessage);
        }

        $response->emailMeta = (object)[];
        $response->emailMeta->inbox = $inboxCounter;
        $response->emailMeta->spam = $spamCounter;
        $response->emailMeta->draft = $draftCounter;

        return response()->json($response);
    }

    public function getUserEmailOptions(){
        $response = [];
        $users = User::all()->take(50)->get();
        foreach ($users as $user) {
            $option = (object)[];
            $option->avatar = '/images/'.$user->avatar;
            $option->name = $user->fullName;
            array_push($response, $option);
        }

        return response()->json($response);
    }

    public function sendEmail(Request $request){
        $for = $request->messageFor;
        $subject = $request->messageSubject;
        $content = $request->messageContent;

        if ($for != null && $subject != null && $content != null) {
            $userToSendMessage = User::where('username', $for)->orWhere('email', $for)->take(1)->get()[0];
            $currentUser = Auth::user();

            if ($userToSendMessage == null) {
                return response()->json([], 404);
            }
            $message = new Message();
            $message->user_id = $currentUser->id;
            $message->from_id = $currentUser->id;

            $message->to_id = $userToSendMessage->id;
            $message->subject = $subject;
            $message->message = $content;
            $message->folder = 'inbox';
            $message->isStarred = 0;
            $message->isRead = 0;

            $message->save();
            return response()->json([], 200);
        }

        return response()->json([], 400);
    }
}
