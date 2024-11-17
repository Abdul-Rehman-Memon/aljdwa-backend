<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\Payment;
use App\Models\EntrepreneurAgreement;

class EntrepreneurDetail extends Model
{
    protected $table = 'entrepreneur_details';

    use HasUuids;
      // Ensure to set the key type and incrementing correctly for UUIDs
    //   protected $keyType = 'string';
    //   public $incrementing = false;

    // Define fillable fields if needed
    protected $fillable = [
        'user_id',
        'position',
        'major',
        'resume',
        'website',
        'project_description',
        'problem_solved',
        'solution_offering',
        'previous_investment',
        'company_registered',
        'saudi_vision_alignment', 
        'positive_impact', 
        'help_needed', 
        'industry_sector',
        'business_model',
        'patent',
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

    // Define relationships to User model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*-- hasOne relation for login api --*/
    public function user_entrepreneur_details_agreement()
    {
        return $this->hasOne(EntrepreneurAgreement::class,'entrepreneur_details_id','id');
    }
    /*-- hasOne relation for login api --*/
    public function user_entrepreneur_details_payment()
    {
        return $this->hasOne(Payment::class,'entrepreneur_details_id','id');
    }
    /*-- hasMany relations for other apis --*/
    public function entrepreneur_details_agreement()
    {
        return $this->hasMany(EntrepreneurAgreement::class,'entrepreneur_details_id','id');
    }

    public function entrepreneur_details_payment()
    {
        return $this->hasMany(Payment::class,'entrepreneur_details_id','id');
    }

   

    
}

