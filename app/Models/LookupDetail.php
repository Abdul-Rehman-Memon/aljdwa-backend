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

    // Define relationships to  Lookup model
    public function lookups()
    {
        return $this->belongsTo(Lookup::class);
    }

}

