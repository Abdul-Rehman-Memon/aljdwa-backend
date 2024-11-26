<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    protected $table = 'messages';

    protected $primaryKey = 'message_id';

    use HasFactory;

    // Define fillable fields if needed
    protected $fillable = [
        'message_text',
        'attachment_url',
        'is_read',
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'is_read',
        'status'
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
    public function message_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }

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

