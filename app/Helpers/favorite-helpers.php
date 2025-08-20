<?php

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



if (!function_exists('favorites')) {
    function favorites()
    {
        return Favorite::where(function ($q) {
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } else {
                $q->where('session_id', Session::getId());
            }
        });
    }
}

if (!function_exists('favorites_count')) {
    function favorites_count()
    {
        return favorites()->count();
    }
}

if (!function_exists('favorites_session_id')) {
    function favorites_session_id()
    {
        $sessionId = session('favorites');
        if (!$sessionId) {
            $sessionId = uniqid();
            Session::put('favorites', $sessionId);
        }
        return $sessionId;
    }
}
