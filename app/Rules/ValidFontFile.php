<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFontFile implements ValidationRule
{
    public static function acceptedMimes()
    {
        return [
            'font/ttf',
            'font/otf',
            'font/woff',
            'font/woff2',
            'application/font-woff',
            'application/x-font-ttf',
            'application/x-font-otf',
            'application/vnd.ms-opentype',
            'font/sfnt',
            'application/x-font-truetype',
            'application/x-font-opentype',
            'application/font-sfnt'
        ];
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value->getMimeType(), self::acceptedMimes())) {
            $fail('The :attribute is not valid font file!');
        }
    }
}
