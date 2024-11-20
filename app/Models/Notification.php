<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LookupDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

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
        'sender_id',
        'receiver_id',
        'message',
        'notification_type',
        'is_read',
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
  
     // Relationship to User as the sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship to User as the receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}

