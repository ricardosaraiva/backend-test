<?php

namespace Model;

use Validation\Validation;
use Doctrine\ORM\EntityManager;

abstract class Model 
{
    protected $em;
    protected $user;
    protected $messageError = [];
    protected $rules = [];

    public function __construct(EntityManager $em, $user) {
        $this->em = $em;
        $this->user = $user;
    }

    protected function offset ($page, $itemsPerPage) {
        $page = $page < 1 ? 1 : $page;
        return ($page - 1) * $itemsPerPage;
    }

    public function isValid() {
        $validation = new Validation();

        foreach ($this->rules as $field => $ruleAndParameters) {

            $rule = is_string($ruleAndParameters) ? $ruleAndParameters : $ruleAndParameters[0];
            $args = (array) $ruleAndParameters;
            unset($args[0]);
          
            if(!$validation->validate($this->{$field}, $rule, $args)) {
                $this->messageError[] = [
                    'field' => $field,
                    'message' => $validation->getError()
                ];
            }

        }

        return count($this->messageError) == 0;
    }

    public function getMessageErrorValidation() {
        return $this->messageError[0];
    }

    public function getAllMessageErrorValidation() {
        return $this->messageError;
    }
}