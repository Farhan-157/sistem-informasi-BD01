<?php

namespace Tests;

use App\MatkulService;
use App\DatabaseWrapper;
use PHPUnit\Framework\TestCase;

class MatkulServiceTest extends TestCase
{
    private $dbMock;
    private MatkulService $service;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(DatabaseWrapper::class);
        $this->service = new MatkulService($this->dbMock);
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

        $result = $this->service->tambah('INF-103', 'Pemrograman Web', '3');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil ditambahkan', $result['pesan']);
    }

    public function testTambahEmptyKode(): void
    {
        $result = $this->service->tambah('', 'Pemrograman Web', '3');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
        $this->assertStringContainsString('tidak boleh kosong', $result['pesan']);
    }

    public function testTambahEmptyNama(): void
    {
        $result = $this->service->tambah('INF-103', '', '3');

        $this->assertFalse($result['success']);
    }

    public function testTambahEmptySks(): void
    {
        $result = $this->service->tambah('INF-103', 'Pemrograman Web', '');

        $this->assertFalse($result['success']);
    }

    public function testTambahInvalidKodeFormat(): void
    {
        $result = $this->service->tambah('INF 103', 'Pemrograman Web', '3');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format Kode MK tidak valid', $result['pesan']);
    }

    public function testTambahInvalidSksZero(): void
    {
        $result = $this->service->tambah('INF-103', 'Pemrograman Web', '0');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('SKS harus berupa angka antara 1-8', $result['pesan']);
    }

    public function testTambahInvalidSksOver8(): void
    {
        $result = $this->service->tambah('INF-103', 'Pemrograman Web', '9');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('SKS harus berupa angka antara 1-8', $result['pesan']);
    }

    public function testTambahInvalidSksNonNumeric(): void
    {
        $result = $this->service->tambah('INF-103', 'Pemrograman Web', 'abc');

        $this->assertFalse($result['success']);
    }

    public function testTambahDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('Duplicate key');

        $result = $this->service->tambah('INF-103', 'Pemrograman Web', '3');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal menambahkan', $result['pesan']);
    }

    // --- Edit Tests ---

    public function testEditSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->edit('INF-103', 'INF-104', 'Basis Data', '4');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil diupdate', $result['pesan']);
    }

    public function testEditEmptyFields(): void
    {
        $result = $this->service->edit('INF-103', '', 'Basis Data', '3');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testEditInvalidKodeFormat(): void
    {
        $result = $this->service->edit('INF-103', 'INF@104', 'Basis Data', '3');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format Kode MK tidak valid', $result['pesan']);
    }

    public function testEditInvalidSks(): void
    {
        $result = $this->service->edit('INF-103', 'INF-104', 'Basis Data', '0');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('SKS harus berupa angka antara 1-8', $result['pesan']);
    }

    public function testEditDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('DB error');

        $result = $this->service->edit('INF-103', 'INF-104', 'Basis Data', '3');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal update', $result['pesan']);
    }

    // --- Hapus Tests ---

    public function testHapusSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->hapus('INF-103');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil dihapus', $result['pesan']);
    }

    public function testHapusEmptyKode(): void
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

        $result = $this->service->hapus('INF-103');

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
            ['kodemk' => 'INF-103', 'namamk' => 'Pemrograman Web', 'sks' => '3'],
            ['kodemk' => 'INF-104', 'namamk' => 'Basis Data', 'sks' => '4'],
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
        $this->assertSame('INF-103', $result[0]['kodemk']);
        $this->assertSame('Basis Data', $result[1]['namamk']);
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
