<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::create([
            'user_id' => auth()->id() ?? $user->id,
            'action' => 'created',
            'data' => json_encode($user->toArray())
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'data' => json_encode($user->getChanges())
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'data' => json_encode($user->toArray())
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
