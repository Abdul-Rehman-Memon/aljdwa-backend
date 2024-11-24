<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\Payment;
use App\Models\EntrepreneurAgreement;

class CoFounder extends Model
{
    protected $table = 'co_founders';

    use HasUuids;
      // Ensure to set the key type and incrementing correctly for UUIDs
    //   protected $keyType = 'string';
    //   public $incrementing = false;

    // Define fillable fields if needed
    protected $fillable = [
        'user_id',
        'co_founder_name',
        'position',
        'major',
        'resume',
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

    // Define the inverse relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
      
}

