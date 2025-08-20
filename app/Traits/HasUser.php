<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userName(): Attribute
    {
        return Attribute::get(fn() => $this->user?->display_name);
    }
    public function userPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->user?->permalink);
    }
}
