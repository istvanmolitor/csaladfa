<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    public function index()
    {
        return view('family-members.index');
    }

    public function apiIndex()
    {
        return response()->json([
            'data' => Auth::user()->familyMembers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date',
            'death_place' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $familyMember = Auth::user()->familyMembers()->create($validated);

        return response()->json(['data' => $familyMember], 201);
    }

    public function show(FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        return response()->json(['data' => $familyMember]);
    }

    public function update(Request $request, FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date',
            'death_place' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $familyMember->update($validated);

        return response()->json(['data' => $familyMember]);
    }

    public function destroy(FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        $familyMember->delete();

        return response()->json(null, 204);
    }

    protected function authorizeOwner(FamilyMember $familyMember)
    {
        if ($familyMember->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
