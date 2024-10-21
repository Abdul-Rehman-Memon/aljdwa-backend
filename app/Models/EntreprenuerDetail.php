<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EntreprenuerDetail extends Model
{
    protected $table = 'entreprenuer_details';

    use HasUuids;
      // Ensure to set the key type and incrementing correctly for UUIDs
    //   protected $keyType = 'string';
    //   public $incrementing = false;

    // Define fillable fields if needed
    protected $fillable = [
        'user_id',
        'website',
        'project_description',
        'problem_solved',
        'solution_offering',
        'previous_investment',
        'industry_sector',
        'business_model',
        'patent',
    ];

    // Define relationships to User model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

