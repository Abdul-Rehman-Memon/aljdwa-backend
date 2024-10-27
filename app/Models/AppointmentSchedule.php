<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AppointmentSchedule extends Model
{
    protected $table = 'appointments_schedule';

    public static function boot()
    {
        parent::boot();
        // Override the created event
        static::creating(function ($model) {
            $model->updated_at = null;  // Set updated_at to null on creation
        });
    }

    // Define fillable fields if needed
    protected $fillable = [
        'date',
        'time',
        'duration',
        'week_day',
        'added_by',
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
    public function appointment_schedule_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}

