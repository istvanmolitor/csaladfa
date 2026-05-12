<?php

use App\Http\Controllers\FamilyMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/family-members', [FamilyMemberController::class, 'index'])->name('family-members.index');

    Route::prefix('api')->group(function () {
        Route::get('/family-members', [FamilyMemberController::class, 'apiIndex']);
        Route::post('/family-members', [FamilyMemberController::class, 'store']);
        Route::get('/family-members/{familyMember}', [FamilyMemberController::class, 'show']);
        Route::put('/family-members/{familyMember}', [FamilyMemberController::class, 'update']);
        Route::delete('/family-members/{familyMember}', [FamilyMemberController::class, 'destroy']);
    });
});
