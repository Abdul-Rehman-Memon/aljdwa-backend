<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LookupDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'payments';

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
        'payments_details',
        'payment_reference',
        'entrepreneur_id',
        'entrepreneur_details_id',
        'invoice_Id',
        'currency',
        'amount',
        'tax',
        'total_amount',
        'voucher',
        'payment_date',
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

    // Add this to convert payment_date into timestamp
    public function getPaymentDateAttribute($value)
    {
        return strtotime($value); // Converts date to timestamp
    }
    ////////////////////////////////////
    public function payment_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

    public function payment_entrepreneur_detail()
    {
        return $this->belongsTo(EntrepreneurDetail::class,'entrepreneur_details_id','id');
    }

}

