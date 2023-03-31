<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DOBMatchesID implements Rule
{
    private $idNumber;
    /**
     * Create a new rule instance.
     *
     * @param  string  $idNumber
     * @return void
     */
    public function __construct($idNumber)
    {
        $this->idNumber = $idNumber;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !strcmp(substr($this->idNumber,0,6),substr($value,8,2).substr($value,3,2).substr($value,0,2));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ID Number does not match Date of Birth.';
    }
}
