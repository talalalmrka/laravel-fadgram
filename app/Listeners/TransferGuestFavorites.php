<?php

namespace App\Listeners;

use App\Models\Favorite;
use App\Events\LoggedIn;
use Illuminate\Support\Facades\Session;

class TransferGuestFavorites
{
    /**
     * Handle the event.
     *
     * @param  LoggedIn  $event
     * @return void
     */
    public function handle($event)
    {
        // dd($event);
        $sessionId = $event->sessionId;
        $user = $event->user;

        Favorite::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->update([
                'user_id' => $user->id,
                'session_id' => null,
            ]);
    }
}
