<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouthProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'birth_date',
        'education_level',
        'bio',
        'skills',
        'availability',
        'contact_number',
        'location',
        'verified',
    ];

    protected $casts = [
        'skills' => 'array', // because it’s JSON
        'verified' => 'boolean',
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
