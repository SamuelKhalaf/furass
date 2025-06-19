<?php

namespace App\Rules;

use App\Models\PathPoint;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPathPoint implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Skip validation for null values
        if (is_null($value)) {
            return;
        }

        // Validate that the path point exists
        if (!PathPoint::where('id', $value)->exists()) {
            $fail('The selected path point is invalid.');
        }
    }
}
