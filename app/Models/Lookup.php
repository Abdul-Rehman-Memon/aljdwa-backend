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

    // Define relationships to  LookupDetails model
    public function lookupdetails()
    {
        return $this->hasMany(LookupDetail::class, 'lookup_id');
    }
}

