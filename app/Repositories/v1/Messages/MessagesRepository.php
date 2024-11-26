<?php

namespace App\Repositories\v1\Messages;

use App\helpers\appHelpers;
use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\Message;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Events\GotMessage;

class MessagesRepository implements MessagesInterface
{
    public function createMessage(array $data)
    {
        $userId   = Auth::user()->id;
        $data['sender_id'] = $userId;

        if (isset($data['attachment'])) {
            $fileInfo['user_id'] = $userId; 
            $fileInfo['file'] = $data['attachment']; 
            $fileInfo['fileName'] = 'attachment'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['attachment_url'] = $filePath;
        }

        $message = Message::create($data);
        $message = Message::with(['sender','receiver'])->find($message->message_id);
        $receiver = User::find($data['receiver_id']);
        $sender = User::find($data['sender_id']);
        // GotMessage::dispatch($receiver, $sender,"We've got a new announcement!");
        broadcast(new GotMessage($receiver, $sender, $message->toArray()));
        return $message; 
    }

    public function getMessage(string $senderId)
    {
        $userId = Auth::id();
        return Message::with(['sender', 'receiver'])
        ->where(function ($query) use ($senderId, $userId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($senderId, $userId) {
            $query->where('receiver_id', $senderId)
                  ->where('sender_id', $userId);
        })
        ->get();  
    }

    public function markMessageAsRead(string $senderId)
    {
        $userId   = Auth::id();
        $userRole = appHelpers::getUserRole($userId);

        $result = Message::where('sender_id', $senderId)
                ->where('receiver_id', $userId);

        return $result->update(['is_read' => 1]);
    }


}
