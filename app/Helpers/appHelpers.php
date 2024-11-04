<?php

namespace App\helpers;

use App\Models\User;
use App\Models\Lookup;
use App\Models\LookupDetail;
use App\Models\MentorsAssignment;
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

}
