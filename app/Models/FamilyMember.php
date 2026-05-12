<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'maiden_name',
        'gender',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'nationality',
        'occupation',
        'bio',
        'profile_photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
