<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha;
class Captcha implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value) {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $response =  $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }

    public function  message() {
        return 'Please complete the recaptcha to submit the form!';
    }

}
