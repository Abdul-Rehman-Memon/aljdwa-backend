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
        'link',
        'meeting_password',
        'agenda',
        'meeting_date_time',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
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

}

