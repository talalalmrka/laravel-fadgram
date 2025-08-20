<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Favoritable
{
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'model');
    }

    /**
     * Is the current visitor (user or session) favoriting this?
     */
    public function isFavorited(): bool
    {
        $query = $this->favorites()->where(function ($q) {
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } else {
                $q->where('session_id', Session::getId());
            }
        });

        return $query->exists();
    }

    /**
     * Toggle favorite on/off.
     */
    public function toggleFavorite(): bool
    {
        $sessionId = Session::getId();
        $userId    = Auth::id();

        // Check existing
        $exists = $this->favorites()
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->exists();

        if ($exists) {
            // Remove it
            $this->favorites()
                ->where(function ($q) use ($userId, $sessionId) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->where('session_id', $sessionId);
                    }
                })
                ->delete();

            return false; // now unfavorited
        }

        // Create it
        $this->favorites()->create([
            'user_id'    => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);

        return true; // now favorited
    }

    /**
     * Count of total favorites
     */
    public function favoritesCount(): int
    {
        return $this->favorites()->count();
    }
}
