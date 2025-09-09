<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    /** @use HasFactory<\Database\Factories\PatternFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'icon',
        'description',
        'block',
    ];
    public function block(): Attribute
    {
        return Attribute::make(
            // decode JSON strings or return array as-is; default to empty array
            get: fn($value) => is_string($value)
                ? (json_decode($value, true) ?? [])
                : ($value ?? []),

            // when saving, ensure it's stored as JSON string (if it's an array/object)
            set: fn($value) => is_array($value) || is_object($value)
                ? json_encode($value)
                : $value
        );
    }
}
