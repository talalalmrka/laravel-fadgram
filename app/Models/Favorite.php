<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory,
        HasUser;
    protected $fillable = [
        'user_id',
        'session_id',
        'model_type',
        'model_id',
    ];
    protected $with = [
        'model',
    ];
    public function model()
    {
        return $this->morphTo();
    }
    public static function login()
    {
        $sessionId = Session::getId();
        $favorites = static::where('session_id', $sessionId)->where('user_id', null);
        if ($favorites) {
            foreach ($favorites as $favorite) {
                $favorite->user_id = Auth::id();
                $favorite->save();
            }
        }
    }
}
