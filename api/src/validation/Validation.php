<?php

namespace Validation;

use Respect\Validation\Validator;

class Validation {
    private $error;

    public function validate($value, $rule, $args = [], $messageError = '') {
        $this->error = '';

        $func = sprintf('%s::%s', Validator::class,  $rule);

        $validateRule = call_user_func_array($func, (array) $args);

        if(empty($messageError)) {
            $messageError = call_user_func_array([new ValidationDefaultMessages, $rule], $args);
        }

        if(!$validateRule->validate($value)) {
            $this->error = $messageError;

            return false;
        }

        return true;
    }

    public function getError() {
        return $this->error;
    }
}