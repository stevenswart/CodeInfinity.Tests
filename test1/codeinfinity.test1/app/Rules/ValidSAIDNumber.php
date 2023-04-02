<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidSAIDNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // a) Add all the digits of the ID number in the odd positions (except for the last number, which is the control digit):

        $digit1 = substr($value, 0, 1);
        $digit3 = substr($value, 2, 1);
        $digit5 = substr($value, 4, 1);
        $digit7 = substr($value, 6, 1);
        $digit9 = substr($value, 8, 1);
        $digit11 = substr($value, 10, 1);
        $sumOdd = ((int)$digit1 + (int)$digit3 + (int)$digit5 + (int)$digit7 + (int)$digit9 + (int)$digit11);

        // b) Take all the even digits as one number and multiply that by 2:

        $digit2 = substr($value, 1, 1);
        $digit4 = substr($value, 3, 1);
        $digit6 = substr($value, 5, 1);
        $digit8 = substr($value, 7, 1);
        $digit10 = substr($value, 9, 1);
        $digit12 = substr($value, 11, 1);

        $productEven = (string)((int)($digit2.$digit4.$digit6.$digit8.$digit10.$digit12) * 2);

        // c) Add the digits of this number together (in b)

        $even1 = $productEven[0];
        $even2 = $productEven[1];
        $even3 = $productEven[2];
        $even4 = $productEven[3];
        $even5 = $productEven[4];
        $even6 = $productEven[5];

        $sumEven = (int)$even1 + (int)$even2 + (int)$even3 + (int)$even4 + (int)$even5 + (int)$even6;

        // d) Add the answer of C to the answer of A

        $result = $sumOdd + $sumEven;

        // e) Subtract the second character from D from 10, this number should now equal the control character

        $controlChar = 10 - ((string)$result)[1];

        // f) Use the Units Character from E. (Sometimes the Answer in E can be 10, so need to just use the return the 0)

        if ($controlChar > 10)
        {
            $controlChar = 0;
        }

        return (int)($value[12]) == $controlChar;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This is not a valid South African Identity Number.';
    }
}
