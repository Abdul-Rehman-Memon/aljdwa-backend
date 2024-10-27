<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    // protected $table = 'lookups';

    // Define fillable fields if needed
    protected $fillable = [
        'name',
        'description'
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

    // Define relationships to  LookupDetails model
    public function lookup_details()
    {
        return $this->hasMany(LookupDetail::class, 'lookup_id');
    }
}

