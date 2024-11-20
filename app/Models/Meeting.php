<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    protected $table = 'meetings';

    use HasFactory;

    // Define fillable fields if needed
    protected $fillable = [
        'initiator_id',
        'participant_id',
        'start_url',
        'meeting_id',
        'meeting_password',
        'join_url',
        'agenda',
        'meeting_date_time',
        'duration',
        'status',
    ];

    protected $hidden = [
        // 'created_at',
        // 'updated_at',
    ];

    // Add this to convert created_at into timestamp
    public function getCreatedAtAttribute($value)
    {
        return strtotime($value); // Converts date to timestamp
    }

    // Add this to convert updated_at into timestamp
    public function getUpdatedAtAttribute($value)
    {
        return strtotime($value); // Converts date to timestamp
    }

    ////////////////////////////////////
    public function meeting_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

       // Relationship to get the initiator details
       public function initiator()
       {
           return $this->belongsTo(User::class, 'initiator_id');
       }
   
       // Relationship to get the participant details
       public function participant()
       {
           return $this->belongsTo(User::class, 'participant_id');
       }

}

