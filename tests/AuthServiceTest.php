<?php

namespace Tests;

use App\AuthService;
use App\DatabaseWrapper;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    private $dbMock;
    private AuthService $authService;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(DatabaseWrapper::class);
        $this->authService = new AuthService($this->dbMock);
    }

    private function mockEscapeString(): void
    {
        $this->dbMock->method('escapeString')
            ->willReturnCallback(function ($val) {
                return addslashes($val);
            });
    }

    // --- Login Tests ---

    public function testLoginSuccess(): void
    {
        $this->mockEscapeString();

        $mockResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturn($mockResult);
        $this->dbMock->method('numRows')
            ->willReturn(1);

        $result = $this->authService->login('admin', 'password123');

        $this->assertTrue($result['success']);
        $this->assertSame('admin', $result['username']);
    }

    public function testLoginInvalidCredentials(): void
    {
        $this->mockEscapeString();

        $mockResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturn($mockResult);
        $this->dbMock->method('numRows')
            ->willReturn(0);

        $result = $this->authService->login('admin', 'wrongpass');

        $this->assertFalse($result['success']);
        $this->assertSame('Username atau Password salah!', $result['error']);
    }

    public function testLoginEmptyUsername(): void
    {
        $result = $this->authService->login('', 'password123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Username tidak valid', $result['error']);
    }

    public function testLoginShortUsername(): void
    {
        $result = $this->authService->login('ab', 'password123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Username tidak valid', $result['error']);
    }

    public function testLoginEmptyPassword(): void
    {
        $result = $this->authService->login('admin', '');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Password tidak valid', $result['error']);
    }

    public function testLoginShortPassword(): void
    {
        $result = $this->authService->login('admin', 'ab');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Password tidak valid', $result['error']);
    }

    // --- Register Tests ---

    public function testRegisterSuccess(): void
    {
        $this->mockEscapeString();

        $checkResult = $this->createStub(\stdClass::class);
        $insertResult = true;

        $this->dbMock->method('query')
            ->willReturnOnConsecutiveCalls($checkResult, $insertResult);
        $this->dbMock->method('numRows')
            ->willReturn(0);

        $result = $this->authService->register('newuser', 'pass123');

        $this->assertTrue($result['success']);
        $this->assertSame('Registrasi berhasil', $result['message']);
    }

    public function testRegisterDuplicateUsername(): void
    {
        $this->mockEscapeString();

        $checkResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturn($checkResult);
        $this->dbMock->method('numRows')
            ->willReturn(1);

        $result = $this->authService->register('existing', 'pass123');

        $this->assertFalse($result['success']);
        $this->assertSame('Username sudah digunakan!', $result['error']);
    }

    public function testRegisterInvalidUsername(): void
    {
        $result = $this->authService->register('ab', 'pass123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Username tidak valid', $result['error']);
    }

    public function testRegisterInvalidPassword(): void
    {
        $result = $this->authService->register('validuser', 'ab');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Password tidak valid', $result['error']);
    }

    public function testRegisterDbFailure(): void
    {
        $this->mockEscapeString();

        $checkResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturnOnConsecutiveCalls($checkResult, false);
        $this->dbMock->method('numRows')
            ->willReturn(0);
        $this->dbMock->method('error')
            ->willReturn('DB error');

        $result = $this->authService->register('newuser', 'pass123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal registrasi', $result['error']);
    }

    // --- Find User Tests ---

    public function testFindUserSuccess(): void
    {
        $this->mockEscapeString();

        $mockResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturn($mockResult);
        $this->dbMock->method('numRows')
            ->willReturn(1);

        $result = $this->authService->findUser('admin');

        $this->assertTrue($result['found']);
        $this->assertSame('admin', $result['username']);
    }

    public function testFindUserNotFound(): void
    {
        $this->mockEscapeString();

        $mockResult = $this->createStub(\stdClass::class);

        $this->dbMock->method('query')
            ->willReturn($mockResult);
        $this->dbMock->method('numRows')
            ->willReturn(0);

        $result = $this->authService->findUser('nonexistent');

        $this->assertFalse($result['found']);
        $this->assertSame('Username tidak ditemukan', $result['error']);
    }

    public function testFindUserInvalidUsername(): void
    {
        $result = $this->authService->findUser('ab');

        $this->assertFalse($result['found']);
        $this->assertStringContainsString('Username tidak valid', $result['error']);
    }

    // --- Reset Password Tests ---

    public function testResetPasswordSuccess(): void
    {
        $this->mockEscapeString();

        $this->dbMock->method('query')
            ->willReturn(true);

        $result = $this->authService->resetPassword('admin', 'newpass123');

        $this->assertTrue($result['success']);
        $this->assertSame('Password berhasil diubah', $result['message']);
    }

    public function testResetPasswordInvalidUsername(): void
    {
        $result = $this->authService->resetPassword('ab', 'newpass123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Username tidak valid', $result['error']);
    }

    public function testResetPasswordInvalidNewPassword(): void
    {
        $result = $this->authService->resetPassword('admin', 'ab');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Password baru tidak valid', $result['error']);
    }

    public function testResetPasswordDbFailure(): void
    {
        $this->mockEscapeString();

        $this->dbMock->method('query')
            ->willReturn(false);
        $this->dbMock->method('error')
            ->willReturn('Connection lost');

        $result = $this->authService->resetPassword('admin', 'newpass123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal mengubah password', $result['error']);
    }
}
