<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationStatus extends Model
{
    protected $table = 'application_status';

    use HasFactory;

    // Define fillable fields if needed
    protected $fillable = [
        'user_id',
        'status',
        'reason',
        'status_by',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'user_id',
        'status',
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
    public function application_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

}

