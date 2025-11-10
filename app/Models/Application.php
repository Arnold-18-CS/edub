<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Opportunity;
use App\Models\YouthProfile;

class Application extends Model
{
    protected $fillable = [
        'opportunity_id',
        'youth_profile_id',
        'status',
        'cover_letter',
        'applied_on',
    ];

    protected $casts = [
        'applied_on' => 'date',
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function youthProfile()
    {
        return $this->belongsTo(YouthProfile::class);
    }

    // Access user through youthProfile relationship (helper method)
    public function getUserAttribute()
    {
        return $this->youthProfile ? $this->youthProfile->user : null;
    }
}
