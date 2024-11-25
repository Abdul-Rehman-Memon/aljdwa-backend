<?php

namespace App\helpers;

use App\Models\User;
use App\Models\Lookup;
use App\Models\LookupDetail;
use App\Models\MentorsAssignment;
use App\Models\Notification;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Events\GotNotification;
use App\Events\AdminNotification;

class appHelpers
{

    public static function lookUpId($name = null,$value = null) {
        $name = ucfirst(strtolower($name));
        $value   = strtolower($value);
        $result =  Lookup::join('lookup_details','lookup_details.lookup_id','lookups.id')
        ->where('name',$name)
        ->where('lookup_details.value',$value)
        ->first();
        if($result){
            return $result->id;
        }
        return null; 
    }

    public static function lookUpValue($id) {
        $result =  LookupDetail::where('id',$id)->first();
        if($result){
            return $result->value;
        }
        return null; 
    }

    

    public static function getUser($userId = null) {
        if($userId){
            return User::find($userId)->load(['user_role','user_status']);
        }
        return User::get()->load(['user_role','user_status']);
    }
    
    public static function getUserRole($userId = null) {
        $user =  User::find($userId)->load('user_role');
        return $user->user_role->value;
    }

    public static function isAdmin($userId = null) {
        $user =  User::find($userId)->load('user_role');
        return ($user->user_role->value === 'admin') ?? false;
    }
    
    public static function isMentor($userId = null) {
        $user =  User::find($userId)->load('user_role');
        return ($user->user_role->value === 'mentor') ?? false;
    }
    
    public static function isEntrepreneur($userId = null) {
        $user =  User::find($userId)->load('user_role');
        return ($user->user_role->value === 'entrepreneur') ?? false;
    }
    
    public static function isInvestor($userId = null) {
        $user =  User::find($userId)->load('user_role');
        return ($user->user_role->value === 'investor') ?? false;
    }

    /* check is mentor assigned to current logged in entrepreneur */
    public static function isMentorAssigned($entrepreneurId,$mentorId) {
        if(self::getUserRole($entrepreneurId) !== 'admin' )
            return MentorsAssignment::whereHas('entrepreneur_details', function ($query) use ($entrepreneurId) {
                    $query->where('user_id', $entrepreneurId);
                })
                ->where('mentor_id',$mentorId)
                ->first();
                
        return true;
    }

    /*-- Upload File --*/
    public static function uploadFile(array $data)
    {
        $userId   = $data['user_id'];
        $userRole = self::getUserRole($userId);
        $file     = $data['file'];
        $fileName = $data['fileName'];
        // Define the directory path: user_role/user_id/fileName/
        $directory = "{$userRole}/{$userId}/{$fileName}";

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

    public static function  hyperPayCreateCheckout($data)
    {

        $url = env('PAYMENT_URL') . "/v1/checkouts";
        $bearer_token = env('PAYMENT_KEY');
        $isTestMode   = env('IS_TEST_MODE'); //testMode=EXTERNAL
        $createRegistration = env('createRegistration');

        $ENTITY_ID  = env('PAYMENT_ENTITY_ID');
        
        $cardType = $data['card_type'] ?? NULL;

        if ($cardType && $cardType == 'mada') {
            $ENTITY_ID = env('MADA_ENTITY_ID');
        }
        if ($cardType && $cardType == 'applePay') {
            $ENTITY_ID = env('APPLEPAY_ENTITY_ID');
        }

        $getLastId  = $data['entrepreneur_details_id'];
        $merchantTransactionId = strval($getLastId);
        $email = Auth::user()->email;
        $name  = Auth::user()->founder_name;
        $amount    = $data['amount'];
        $currency  = $data['currency'];
        $memo      = 'subscription';

        $data = "entityId=" . $ENTITY_ID;
        
        if ($createRegistration) {
            // $data = $data . "&createRegistration=true";
        }
         // "&paymentBrand=VISA" .
         $data = $data ."&amount=$amount.00" .
         "&currency=$currency" .
         "&paymentType=DB" .
         "&integrity=true";

         if ($isTestMode) {
            $data = $data . "&testMode=" .$isTestMode;
        } 

         $data = $data ."&customParameters[3DS2_enrolled]=true" .
         "&merchantTransactionId=$merchantTransactionId" .
        //  "&merchantMemo=$memo" .
         "&customer.email=$email" .
         // '&billing.street1=hyderabad' .
         // '&billing.city=hyderabad' .
         // '&billing.state=sindh' .
         // '&billing.country=pakistan' .
         // '&billing.postcode=7100' .
         "&customer.givenName=$name" .
         "&customer.surname=$name" ; 
         
        //  return $data;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer ' .$bearer_token));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        // return $responseData;
        return json_decode($responseData, true);
    }
    
    
    public static function  verifyHyperPay($data)
    {

        // return $data['amount'];

        $url = env('PAYMENT_URL') . "/v1/checkouts";
        $isTestMode = env('IS_TEST_MODE'); //testMode=EXTERNAL
        $bearer_token = env('PAYMENT_KEY');

        $ENTITY_ID  = env('PAYMENT_ENTITY_ID');

        $cardType = $data['card_type'] ?? NULL;

        if ($cardType && $cardType == 'mada') {
            $ENTITY_ID = env('MADA_ENTITY_ID');
        }
        if ($cardType && $cardType == 'applePay') {
            $ENTITY_ID = env('APPLEPAY_ENTITY_ID');
        }

        $registration_id = $data['payment_id'];
        $amount    = $data['amount'];
        $currency  = $data['currency'];

        $url = env('PAYMENT_URL') . "/v1/registrations/{$registration_id}/payments";
        $data = "entityId=" . $ENTITY_ID;
        $data = $data ."&amount=$amount.00" .
         "&currency=$currency" .
         "&paymentType=DB";
        //  "&integrity=true";
        // return $data;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $bearer_token 
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, env('PAYMENT_CURLOPT_SSL_VERIFYPEER')); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // return $responseData;
        return json_decode($responseData, true);
    }

    //Manage Notifications
    public static function addNotification($data){

        $notification =  Notification::create($data);
        $receiver = User::find($notification['receiver_id']);
        $sender = User::find($notification['sender_id']);

        if ($receiver) {
            broadcast(new GotNotification($receiver, $notification->toArray()));
        }else{
            broadcast(new AdminNotification($notification->toArray()))->toOthers(); 
        }   
    }

    public static function getNotifications($id = null){
        $userId = Auth::user()->id;

        $userRole = self::getUserRole($userId);
        $query = Notification::query();
        if ($userRole === 'admin') {
            $query->where('receiver_id',NULL);  
        }else{
            $query->where('receiver_id',$userId); 
        }

        if ($id) {
            $query->where('id',$id); 
        }

        $result =  $query->get();

        if ($id && $result) {
           self::updateNotificationStatus($id);
        }

        return $result->load(['sender','receiver']);
        
    }

    public static function updateNotificationStatus($id = null){

        $result = Notification::find($id); 
        if ($result) {
            $result->update(['is_read'=>1]);
        }      
    }

    //Manage Zoom Meetings
    public static function createMeeting($data)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' .self::generateToken(),
                'Content-Type' => 'application/json',
            ])->post("https://api.zoom.us/v2/users/me/meetings", [
                'topic' => $data['agenda'],
                'type' => 2, // 2 for scheduled meeting
                'start_time' => Carbon::parse($data['meeting_date_time'])->toIso8601String(),
                'duration' => $data['duration_in_minute'],
            ]);
            
            return $response->json();

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    protected static function generateToken(): string
    {
        try {
            $base64String = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
            $accountId = env('ZOOM_ACCOUNT_ID');

            $responseToken = Http::withHeaders([
                "Content-Type"=> "application/x-www-form-urlencoded",
                "Authorization"=> "Basic {$base64String}"
            ])->post("https://zoom.us/oauth/token?grant_type=account_credentials&account_id={$accountId}");

            return $responseToken->json()['access_token'];

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
    