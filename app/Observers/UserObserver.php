<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Если сразу создаём тренера — можно задать дефолтные значения
        if ($user->hasRole('trainer')) {
            $this->initializeTrainerFields($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('role_id') && $user->hasRole('trainer')) {
            $this->initializeTrainerFields($user);
        }

        if ($user->isDirty('role_id') && $user->wasChanged('role_id')) {
            $previousRole = $user->getOriginal('role_id');
            $previousRoleName = \App\Models\Role::find($previousRole)?->name;

            if ($previousRoleName === 'trainer' && !$user->hasRole('trainer')) {
                $this->clearTrainerFields($user);
            }
        }
    }

    private function initializeTrainerFields(User $user): void
    {
        $user->update([
            'bio' => $user->bio ?? '',
            'specialties' => $user->specialties ?? [],
            'rating' => 0.0,
            'reviews_count' => 0,
        ]);
    }

    private function clearTrainerFields(User $user): void
    {
        $user->update([
            'bio' => null,
            'specialties' => null,
            'rating' => null,
            'reviews_count' => null,
        ]);
    }

    public function deleted(User $user): void {}
    public function restored(User $user): void {}
    public function forceDeleted(User $user): void {}
}
