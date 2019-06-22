<?php

namespace Test\Validation;

use Validation\Validation;
use PHPUnit\Framework\TestCase;
use Respect\Validation\Exceptions\ComponentException;

class ValidationTest extends TestCase {
   public function testInvalidValueFullName() {
       $validation = new Validation();
       $this->assertFalse($validation->isValid('fullName', 'fulano', 'length', [10, 100]));
       $this->assertEquals('fullName', $validation->getError()['field']);
       $this->assertEquals('must contain 10 to 100 characters', $validation->getError()['message']);
   }

   public function testInvalidRuleZipcode() {
       $this->expectException(ComponentException::class);
        $validation = new Validation();
        $this->assertFalse($validation->isValid('zipCode', '00000000', 'zipCode'));
   }
}