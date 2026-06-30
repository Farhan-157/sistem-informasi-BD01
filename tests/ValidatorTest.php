<?php

namespace Tests;

use App\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testIsNotEmptyWithValidString(): void
    {
        $this->assertTrue(Validator::isNotEmpty('hello'));
    }

    public function testIsNotEmptyWithEmptyString(): void
    {
        $this->assertFalse(Validator::isNotEmpty(''));
    }

    public function testIsNotEmptyWithWhitespace(): void
    {
        $this->assertFalse(Validator::isNotEmpty('   '));
    }

    public function testValidateRequiredAllPresent(): void
    {
        $errors = Validator::validateRequired([
            'NIM' => '12345678',
            'Nama' => 'John Doe',
        ]);
        $this->assertEmpty($errors);
    }

    public function testValidateRequiredWithMissing(): void
    {
        $errors = Validator::validateRequired([
            'NIM' => '',
            'Nama' => 'John Doe',
        ]);
        $this->assertCount(1, $errors);
        $this->assertStringContainsString('NIM', $errors[0]);
    }

    public function testValidateRequiredAllMissing(): void
    {
        $errors = Validator::validateRequired([
            'NIM' => '',
            'Nama' => '   ',
        ]);
        $this->assertCount(2, $errors);
    }

    public function testValidateNimValid(): void
    {
        $this->assertTrue(Validator::validateNim('12345678'));
        $this->assertTrue(Validator::validateNim('001'));
    }

    public function testValidateNimInvalid(): void
    {
        $this->assertFalse(Validator::validateNim(''));
        $this->assertFalse(Validator::validateNim('abc'));
        $this->assertFalse(Validator::validateNim('123abc'));
        $this->assertFalse(Validator::validateNim('12 34'));
    }

    public function testValidateNidValid(): void
    {
        $this->assertTrue(Validator::validateNid('D001'));
        $this->assertTrue(Validator::validateNid('DSN-001'));
        $this->assertTrue(Validator::validateNid('abc123'));
    }

    public function testValidateNidInvalid(): void
    {
        $this->assertFalse(Validator::validateNid(''));
        $this->assertFalse(Validator::validateNid('D 001'));
        $this->assertFalse(Validator::validateNid('D@001'));
    }

    public function testValidatePhoneValid(): void
    {
        $this->assertTrue(Validator::validatePhone('081234567890'));
        $this->assertTrue(Validator::validatePhone('+62-812-3456'));
        $this->assertTrue(Validator::validatePhone(''));
    }

    public function testValidatePhoneInvalid(): void
    {
        $this->assertFalse(Validator::validatePhone('abc'));
        $this->assertFalse(Validator::validatePhone('08@123'));
    }

    public function testValidateSksValid(): void
    {
        $this->assertTrue(Validator::validateSks('1'));
        $this->assertTrue(Validator::validateSks('3'));
        $this->assertTrue(Validator::validateSks('8'));
    }

    public function testValidateSksInvalid(): void
    {
        $this->assertFalse(Validator::validateSks(''));
        $this->assertFalse(Validator::validateSks('0'));
        $this->assertFalse(Validator::validateSks('9'));
        $this->assertFalse(Validator::validateSks('abc'));
        $this->assertFalse(Validator::validateSks('-1'));
    }

    public function testValidateKodeMkValid(): void
    {
        $this->assertTrue(Validator::validateKodeMk('INF-103'));
        $this->assertTrue(Validator::validateKodeMk('MK001'));
    }

    public function testValidateKodeMkInvalid(): void
    {
        $this->assertFalse(Validator::validateKodeMk(''));
        $this->assertFalse(Validator::validateKodeMk('MK 001'));
        $this->assertFalse(Validator::validateKodeMk('MK@001'));
    }

    public function testValidateUsernameValid(): void
    {
        $this->assertTrue(Validator::validateUsername('admin'));
        $this->assertTrue(Validator::validateUsername('usr'));
    }

    public function testValidateUsernameInvalid(): void
    {
        $this->assertFalse(Validator::validateUsername(''));
        $this->assertFalse(Validator::validateUsername('ab'));
        $this->assertFalse(Validator::validateUsername(str_repeat('a', 51)));
    }

    public function testValidatePasswordValid(): void
    {
        $this->assertTrue(Validator::validatePassword('abc'));
        $this->assertTrue(Validator::validatePassword('password123'));
    }

    public function testValidatePasswordInvalid(): void
    {
        $this->assertFalse(Validator::validatePassword(''));
        $this->assertFalse(Validator::validatePassword('ab'));
    }

    public function testSanitize(): void
    {
        $this->assertSame('hello', Validator::sanitize('  hello  '));
        $this->assertSame('', Validator::sanitize('   '));
        $this->assertSame('test', Validator::sanitize('test'));
    }
}
