<?php

namespace App\helpers;

use App\Models\User;
use App\Models\Lookup;
use App\Models\LookupDetail;
use App\Models\MentorsAssignment;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


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
        return MentorsAssignment::whereHas('entrepreneur_details', function ($query) use ($entrepreneurId) {
                $query->where('user_id', $entrepreneurId);
            })
            ->where('mentor_id',$mentorId)
            ->first();
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

    
    public static function  hyperPayPaymentgateWay($data)
    {
        $isTestMode = env('IS_TEST_MODE'); //testMode=EXTERNAL
        $ENTITY_ID  = env('PAYMENT_ENTITY_ID');
        $getLastId  = $data['entrepreneur_details_id'];
        $merchantTransactionId = strval($getLastId);
        $email = Auth::user()->email;
        $name  = Auth::user()->founder_name;
        $amount    = $data['amount'];
        $currency  = $data['currency'];
        $cardType  = $data['card_type'] ?? null;
        $user_id   = $data['entrepreneur_id'];
        $user_id   = strval($user_id);
        $memo      = 'subscription';

        if ($cardType == 'mada') {
            $ENTITY_ID = env('MADA_ENTITY_ID');
        }
        if ($cardType == 'applePay') {
            $ENTITY_ID = env('APPLEPAY_ENTITY_ID');
        }

        $url = env('PAYMENT_URL') . "/v1/checkouts";

        $data = "entityId=" . $ENTITY_ID .
            "&amount=$amount.00" .
            "&currency=$currency" .
            "&paymentType=DB" .
            "&merchantMemo=$memo" .
            "&merchantTransactionId=$merchantTransactionId" .
            "&customer.email=$email" .
            "&customer.givenName=$name" .
            "&customer.surname=$name";
        if ($isTestMode) {
            $data = $data . "&testMode=EXTERNAL";
        }
        if ($cardType == 'mada') {
            $data = $data . "&customParameters[branch_id]=1" .
                "&customParameters[teller_id]=1" .
                "&customParameters[device_id]=1" .
                "&customParameters[bill_number]=$merchantTransactionId";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . env('PAYMENT_KEY')
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

}
