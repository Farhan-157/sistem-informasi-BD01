<?php

namespace Tests;

use App\MahasiswaService;
use App\DatabaseWrapper;
use PHPUnit\Framework\TestCase;

class MahasiswaServiceTest extends TestCase
{
    private $dbMock;
    private MahasiswaService $service;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(DatabaseWrapper::class);
        $this->service = new MahasiswaService($this->dbMock);
    }

    private function mockEscapeString(): void
    {
        $this->dbMock->method('escapeString')
            ->willReturnCallback(function ($val) {
                return addslashes($val);
            });
    }

    // --- Tambah Tests ---

    public function testTambahSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->tambah('12345678', 'Ahmad Farhan', '081234567890');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil ditambahkan', $result['pesan']);
    }

    public function testTambahWithoutPhone(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->tambah('12345678', 'Ahmad Farhan');

        $this->assertTrue($result['success']);
    }

    public function testTambahEmptyNim(): void
    {
        $result = $this->service->tambah('', 'Ahmad Farhan');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
        $this->assertStringContainsString('tidak boleh kosong', $result['pesan']);
    }

    public function testTambahEmptyNama(): void
    {
        $result = $this->service->tambah('12345678', '');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testTambahInvalidNimFormat(): void
    {
        $result = $this->service->tambah('abc123', 'Ahmad Farhan');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format NIM tidak valid', $result['pesan']);
    }

    public function testTambahInvalidPhone(): void
    {
        $result = $this->service->tambah('12345678', 'Ahmad Farhan', 'invalid@phone');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format nomor HP tidak valid', $result['pesan']);
    }

    public function testTambahDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('Duplicate entry');

        $result = $this->service->tambah('12345678', 'Ahmad Farhan');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal menambahkan', $result['pesan']);
    }

    // --- Edit Tests ---

    public function testEditSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->edit('12345678', '87654321', 'Ahmad Budi', '081999888777');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil diupdate', $result['pesan']);
    }

    public function testEditEmptyNim(): void
    {
        $result = $this->service->edit('12345678', '', 'Ahmad Budi');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testEditEmptyNama(): void
    {
        $result = $this->service->edit('12345678', '87654321', '');

        $this->assertFalse($result['success']);
    }

    public function testEditInvalidNimFormat(): void
    {
        $result = $this->service->edit('12345678', 'abc', 'Ahmad Budi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format NIM tidak valid', $result['pesan']);
    }

    public function testEditInvalidPhone(): void
    {
        $result = $this->service->edit('12345678', '87654321', 'Ahmad Budi', 'abc@123');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format nomor HP tidak valid', $result['pesan']);
    }

    public function testEditDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('DB error');

        $result = $this->service->edit('12345678', '87654321', 'Ahmad Budi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal update', $result['pesan']);
    }

    // --- Hapus Tests ---

    public function testHapusSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->hapus('12345678');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil dihapus', $result['pesan']);
    }

    public function testHapusEmptyNim(): void
    {
        $result = $this->service->hapus('');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('tidak boleh kosong', $result['pesan']);
    }

    public function testHapusDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('Foreign key constraint');

        $result = $this->service->hapus('12345678');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal hapus', $result['pesan']);
    }

    // --- GetAll Tests ---

    public function testGetAllWithData(): void
    {
        $mockResult = $this->createStub(\stdClass::class);
        $this->dbMock->method('query')->willReturn($mockResult);

        $callCount = 0;
        $rows = [
            ['nim' => '12345678', 'namamhs' => 'Ahmad', 'handphone' => '081234567'],
            ['nim' => '87654321', 'namamhs' => 'Budi', 'handphone' => '089876543'],
        ];

        $this->dbMock->method('fetchAssoc')
            ->willReturnCallback(function () use (&$callCount, $rows) {
                if ($callCount < count($rows)) {
                    return $rows[$callCount++];
                }
                return null;
            });

        $result = $this->service->getAll();

        $this->assertCount(2, $result);
        $this->assertSame('12345678', $result[0]['nim']);
        $this->assertSame('Budi', $result[1]['namamhs']);
    }

    public function testGetAllEmpty(): void
    {
        $mockResult = $this->createStub(\stdClass::class);
        $this->dbMock->method('query')->willReturn($mockResult);
        $this->dbMock->method('fetchAssoc')->willReturn(null);

        $result = $this->service->getAll();

        $this->assertEmpty($result);
    }

    public function testGetAllQueryFails(): void
    {
        $this->dbMock->method('query')->willReturn(false);

        $result = $this->service->getAll();

        $this->assertEmpty($result);
    }
}
