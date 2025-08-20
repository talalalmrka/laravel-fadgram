<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDateFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Accepts PHP date() format strings, e.g. 'Y-m-d', 'd/m/Y', etc.
        // We'll try to format a date with the given format and see if it throws.
        if (!is_string($value) || empty($value)) {
            $fail(__('The :attribute must be a valid date format string.'));
            return;
        }

        // Try to format a known date with the given format
        try {
            $testDate = date($value, strtotime('2020-01-01'));
            // If the format is invalid, date() will return false or an empty string
            if ($testDate === false || $testDate === '') {
                $fail(__('The :attribute must be a valid date format string.'));
            }
        } catch (\Throwable $e) {
            $fail(__('The :attribute must be a valid date format string.'));
        }
    }
}
