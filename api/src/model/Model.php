<?php

namespace Model;

use Validation\Validation;
use Doctrine\ORM\EntityManager;

abstract class Model 
{
    protected $em;
    protected $messageError = [];
    protected $rules = [];

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    protected function offset ($page, $itemsPerPage) {
        $page = $page < 1 ? 1 : $page;
        return ($page - 1) * $itemsPerPage;
    }

    public function isValid() {
        $validation = new Validation();

        foreach ($this->rules as $field => $ruleAndParameters) {

            if(empty($this->{$field})) {
                throw new \InvalidArgumentException('Invalid field');
            }            

            $rule = $ruleAndParameters[0];
            $args = $ruleAndParameters;
            unset($args[0]);

            $isValid = $validation->validate($this->{$field}, $rule, $args);            
            if(!$isValid) {
                $this->messageError = [
                    'field' => $field,
                    'message' => $validation->getError()
                ];
                
                return false;
            }

            return true;
        }

        return true;
    }

    public function getMessageErrorValidation() {
        return $this->messageError;
    }
}