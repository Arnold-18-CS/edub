<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'contact_email',
        'contact_phone',
        'location',
        'description',
        'verified',
    ];

    protected $casts = [
        'verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'organization_id', 'user_id');
    }
}
