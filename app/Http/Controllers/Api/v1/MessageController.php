<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\v1\MessageService;
use Exception;
use App\Http\Helpers\ResponseHelper;
use Carbon\Carbon;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    
    public function markMessageAsRead(Request $request,$id)
    {
        try {
            $user = $this->messageService->markMessageAsRead($id);
            return ResponseHelper::created($user,'Message updated successfully');
        } catch (Exception $e) {
            // Handle the error
            return ResponseHelper::error('Failed to update message.',500,$e->getMessage());
        }
    }


}
