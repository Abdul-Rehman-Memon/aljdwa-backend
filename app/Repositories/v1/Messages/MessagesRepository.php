<?php

namespace App\Repositories\v1\Messages;

use App\Models\User;
use App\Models\EntrepreneurDetail;
use App\Models\Message;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MessagesRepository implements MessagesInterface
{
    public function createMessage(array $data)
    {
        $userId  = Auth::user()->id;
        $data['sender_id'] = $userId;

        $file = $data['attachment'] ?? NULL;

        if ($file) {
            $directory = "public/{$userId}/attachment";
            // Check if directory exists, create it if it doesn’t
            if (!File::exists(storage_path("app/{$directory}"))) {
                File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
            }
            $filePath = Storage::disk('public')->putFileAs($directory, $file, $file->getClientOriginalName());
            $data['attachment_url'] = $filePath;
        }

        return Message::create($data);
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


  
}
