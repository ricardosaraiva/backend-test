<?php

namespace Validation;

class ValidationDefaultMessages {

    private $message = [
        'date' => 'invalid date',
        'time' => 'invalid time'
    ];

    public function length($min, $max = null) {
        return (is_null($max)) ? 
            sprintf('must contain %s characters', $min) :
            sprintf('must contain %s to %s characters', $min, $max); 
    }

    public function __call($name, $args) {
        if(self::$message[$name]) {
            return $this->$message[$name];
        }

        return 'contains an invalid value';
    }
}