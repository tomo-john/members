<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sandbox extends Model
{
    protected $fillable = [
        'name',
        'is_good_boy',
        'birthday',
        'mood',
    ];

    protected $casts = [
        'is_good_boy' => 'boolean',
        'birthday' => 'datetime',
    ];

    // mood
    public const MOOD_IDLE = 'idle';
    public const MOOD_HAPPY = 'happy';
    public const MOOD_SLEEP = 'sleep';

    public const MOODS = [
        self::MOOD_IDLE,
        self::MOOD_HAPPY,
        self::MOOD_SLEEP,
    ];
}
