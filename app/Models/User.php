<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\LookupDetail;
use App\Models\EntreprenuerDetail;
use App\Models\ApplicationStatus;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids,Notifiable,HasApiTokens;


    public static function boot()
    {
        parent::boot();
        // Override the created event
        static::creating(function ($model) {
            $model->updated_at = null;  // Set updated_at to null on creation
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_name',
        'founder_name',
        'email',
        'country_code',
        'phone_number',
        'password',
        'linkedin_profile',
        'reject_reason',
        'approved_At',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
    /*--------- Relations ----------*/
    public function user_role()
    {
        return $this->belongsTo(LookupDetail::class,'role','id');
    }

    // Method to check if the user has a specific role
    public function hasRole(string $roleName): bool
    {
        return $this->user_role && $this->user_role->value === $roleName; // Assuming your roles table has a 'value' field
    }

    public function user_application_status()
    {
        return $this->hasMany(ApplicationStatus::class, 'user_id');
    }

    public function latest_application_status()
    {
        return $this->hasOne(ApplicationStatus::class,'user_id')->latestOfMany();
    }

    public function user_status()
    {
        return $this->belongsTo(LookupDetail::class,'status','id');
    }
    

    //Relation with EntreprenuerDetails model
    public function entreprenuer_details(){

        return $this->hasOne(EntrepreneurDetail::class,'user_id','id');

    }
}
