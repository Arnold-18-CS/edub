<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Application;

class Opportunity extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'requirements',
        'type',
        'start_date',
        'end_date',
        'deadline',
        'duration_weeks',
        'available_slots',
        'approved',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'approved' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
