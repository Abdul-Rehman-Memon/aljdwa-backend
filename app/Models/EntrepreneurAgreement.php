<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LookupDetail;
use App\Models\EntrepreneurDetail;
use App\Models\Payment;

class EntrepreneurAgreement extends Model
{
    protected $table = 'entrepreneur_agreement';

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
        'entrepreneur_details_id',
        'admin_id',
        'signed_at',
        'agreement_details',
        'agreement_document',
        'reject_reason',
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

    // Add this to convert signed_At into timestamp
    public function getSignedAtAttribute($value)
    {
        return strtotime($value); // Converts date to timestamp
    }
    ////////////////////////////////////
    public function agreement_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

    public function agreement_entrepreneur_detail()
    {
        return $this->belongsTo(EntrepreneurDetail::class,'entrepreneur_details_id','id');
    }

}

