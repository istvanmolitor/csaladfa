<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FamilyMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_their_family_members(): void
    {
        $user = User::factory()->create();
        $familyMember = FamilyMember::create([
            'user_id' => $user->id,
            'first_name' => 'János',
            'last_name' => 'Kovács',
            'gender' => 'male',
        ]);

        $response = $this->actingAs($user)->get('/family-members');

        $response->assertStatus(200);
        $response->assertSee('Kovács János');
    }

    public function test_guest_cannot_see_family_members(): void
    {
        $response = $this->get('/family-members');

        $response->assertRedirect('/login');
    }

    public function test_user_cannot_see_others_family_members(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $familyMemberOfUser2 = FamilyMember::create([
            'user_id' => $user2->id,
            'first_name' => 'Béla',
            'last_name' => 'Szabó',
            'gender' => 'male',
        ]);

        $response = $this->actingAs($user1)->get('/family-members');

        $response->assertStatus(200);
        $response->assertDontSee('Szabó Béla');
    }

    public function test_user_can_create_family_member_via_api(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/family-members', [
            'first_name' => 'Anna',
            'last_name' => 'Nagy',
            'gender' => 'female',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('family_members', [
            'user_id' => $user->id,
            'first_name' => 'Anna',
            'last_name' => 'Nagy',
        ]);
    }

    public function test_user_can_update_their_family_member_via_api(): void
    {
        $user = User::factory()->create();
        $member = FamilyMember::create([
            'user_id' => $user->id,
            'first_name' => 'János',
            'last_name' => 'Kovács',
        ]);

        $response = $this->actingAs($user)->putJson("/api/family-members/{$member->id}", [
            'first_name' => 'Jancsi',
            'last_name' => 'Kovács',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('family_members', [
            'id' => $member->id,
            'first_name' => 'Jancsi',
        ]);
    }

    public function test_user_cannot_update_others_family_member(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $member = FamilyMember::create([
            'user_id' => $user2->id,
            'first_name' => 'János',
            'last_name' => 'Kovács',
        ]);

        $response = $this->actingAs($user1)->putJson("/api/family-members/{$member->id}", [
            'first_name' => 'Hacker',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_family_member_via_api(): void
    {
        $user = User::factory()->create();
        $member = FamilyMember::create([
            'user_id' => $user->id,
            'first_name' => 'János',
            'last_name' => 'Kovács',
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/family-members/{$member->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('family_members', ['id' => $member->id]);
    }
}
