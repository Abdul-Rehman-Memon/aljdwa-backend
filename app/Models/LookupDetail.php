<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LookupDetail extends Model
{
    // protected $table = 'lookup_details';

    // Define fillable fields if needed
    protected $fillable = [
        'lookup_id',
        'display_name',
        'value'
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

    // Define relationships to  Lookup model
    public function lookups()
    {
        return $this->belongsTo(Lookup::class);
    }

}

