<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyRelationship extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_member_1_id',
        'family_member_2_id',
        'relationship_type_id',
        'notes',
    ];

    /**
     * Get the first family member.
     */
    public function familyMember1()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_1_id');
    }

    /**
     * Get the second family member.
     */
    public function familyMember2()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_2_id');
    }

    /**
     * Get the relationship type.
     */
    public function relationshipType()
    {
        return $this->belongsTo(RelationshipType::class);
    }
}
