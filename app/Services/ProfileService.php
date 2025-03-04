<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileService
{
    /**
     * Update the user's profile information
     *
     * @param User $user
     * @param array $validatedData
     * @return void
     */
    public function updateProfile(User $user, array $validatedData): void
    {
        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    /**
     * Delete the user's account
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    public function deleteAccount(User $user, Request $request): void
    {
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
} 