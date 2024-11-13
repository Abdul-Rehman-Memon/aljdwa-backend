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
        $userRole = appHelpers::getUserRole($userId);
        $data['sender_id'] = $userId;


        $file = $data['attachment'] ?? NULL;

        if ($file) {

            $fileInfo['userId'] = $userId; 
            $fileInfo['userRole'] = $userRole; 
            $fileInfo['fileName'] = 'attachment'; 
            $fileInfo['file'] = $file; 
            $filePath = $this->uploadAttachmentFile($fileInfo);
            $data['attachment_url'] = $filePath;
        }

        $message = Message::create($data);

        broadcast(new GotMessage($message->toArray()))->toOthers(); 
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

    public function uploadAttachmentFile(array $data)
    {
        extract($data);
        // Define the directory path: user_role/user_id/fileName/
        $directory = "public/{$userRole}/{$userId}/{$fileName}";
        // Check if directory exists, create it if it doesn’t
        if (!File::exists(storage_path("app/{$directory}"))) {
            File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
        }
        
        $timestamp = time();
        $filePath = Storage::disk('public')->putFileAs($directory, $file, "{$timestamp}.{$file->getClientOriginalExtension()}");

        // Generate the full URL for accessing the file
        $fullUrl = asset("storage/" . str_replace('public/', '', $filePath));

        return $fullUrl;
    }

}
