<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TwoFactorAuthentication extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCode($userId)
    {
        // Delete old unused codes
        self::where('user_id', $userId)
            ->where('used', false)
            ->where('expires_at', '<', now())
            ->delete();

        // Generate 6-digit code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'user_id' => $userId,
            'code' => $code,
            'expires_at' => now()->addMinutes(10), // Code expires in 10 minutes
            'used' => false,
        ]);
    }

    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }
}

