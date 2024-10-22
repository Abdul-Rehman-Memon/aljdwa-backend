<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Appointment extends Model
{
    protected $table = 'appoitments';

    use HasUuids;

    // Define fillable fields if needed
    protected $fillable = [
        'user_name',
        'phone',
        'email',
        'request_date_time',
        'link',
        'status',
        'approved_by',
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

}

