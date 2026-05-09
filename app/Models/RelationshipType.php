<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get all family relationships of this type.
     */
    public function familyRelationships()
    {
        return $this->hasMany(FamilyRelationship::class);
    }
}

