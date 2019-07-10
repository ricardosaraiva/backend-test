<?php

namespace Test\Validation;

use Validation\Validation;
use PHPUnit\Framework\TestCase;
use Respect\Validation\Exceptions\ComponentException;

class ValidationTest extends TestCase {
   public function testInvalidFullName() {
       $validation = new Validation();
       $this->assertFalse($validation->validate('fulano', 'length', [10, 100]));
       $this->assertEquals('must contain 10 to 100 characters', $validation->getError());
   }

    public function testInvalidDate() {
        $validation = new Validation();
        $this->assertFalse($validation->validate('2019-01-32', 'date'));
        $this->assertEquals('invalid datetime', $validation->getError());
    }

   public function testInvalidRuleZipcode() {
       $this->expectException(ComponentException::class);
        $validation = new Validation();
        $this->assertFalse($validation->validate('zipCode', '00000000', 'zipCode'));
   }
}