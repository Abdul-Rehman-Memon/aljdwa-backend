<?php

namespace App\Http\Controllers\Api\v1;

use App\helpers\appHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

use Exception;
use App\Http\Helpers\ResponseHelper;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        try {
            $result = appHelpers::getNotifications();
            return ResponseHelper::success($result,'Notifications retrieved successfully');
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve notifications.', 500, $e->getMessage());
        }
    }

    public function getSingleNotification($id)
    {
        try {
            $result = appHelpers::getNotifications($id);
            return ResponseHelper::success($result,'Notifications retrieved successfully');
            
        } catch (Exception $e) {
            return ResponseHelper::error('Failed to retrieve notifications.', 500, $e->getMessage());
        }
    }
}
