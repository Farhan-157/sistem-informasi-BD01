<?php

namespace Tests;

use App\DosenService;
use App\DatabaseWrapper;
use PHPUnit\Framework\TestCase;

class DosenServiceTest extends TestCase
{
    private $dbMock;
    private DosenService $service;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(DatabaseWrapper::class);
        $this->service = new DosenService($this->dbMock);
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

        $result = $this->service->tambah('D001', 'Dr. Budi');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil ditambahkan', $result['pesan']);
    }

    public function testTambahEmptyNid(): void
    {
        $result = $this->service->tambah('', 'Dr. Budi');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
        $this->assertStringContainsString('tidak boleh kosong', $result['pesan']);
    }

    public function testTambahEmptyNama(): void
    {
        $result = $this->service->tambah('D001', '');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testTambahWhitespaceOnly(): void
    {
        $result = $this->service->tambah('   ', '   ');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testTambahInvalidNidFormat(): void
    {
        $result = $this->service->tambah('D 001', 'Dr. Budi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format NID tidak valid', $result['pesan']);
    }

    public function testTambahDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('Duplicate entry');

        $result = $this->service->tambah('D001', 'Dr. Budi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal menambahkan', $result['pesan']);
    }

    // --- Edit Tests ---

    public function testEditSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->edit('D001', 'D002', 'Dr. Andi');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil diupdate', $result['pesan']);
    }

    public function testEditEmptyFields(): void
    {
        $result = $this->service->edit('D001', '', 'Dr. Andi');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
    }

    public function testEditInvalidNidFormat(): void
    {
        $result = $this->service->edit('D001', 'D@002', 'Dr. Andi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Format NID tidak valid', $result['pesan']);
    }

    public function testEditDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('DB error');

        $result = $this->service->edit('D001', 'D002', 'Dr. Andi');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal update', $result['pesan']);
    }

    // --- Hapus Tests ---

    public function testHapusSuccess(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(true);

        $result = $this->service->hapus('D001');

        $this->assertTrue($result['success']);
        $this->assertSame('sukses', $result['tipe']);
        $this->assertStringContainsString('berhasil dihapus', $result['pesan']);
    }

    public function testHapusEmptyNid(): void
    {
        $result = $this->service->hapus('');

        $this->assertFalse($result['success']);
        $this->assertSame('gagal', $result['tipe']);
        $this->assertStringContainsString('tidak boleh kosong', $result['pesan']);
    }

    public function testHapusDbFailure(): void
    {
        $this->mockEscapeString();
        $this->dbMock->method('query')->willReturn(false);
        $this->dbMock->method('error')->willReturn('Foreign key constraint');

        $result = $this->service->hapus('D001');

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
            ['nid' => 'D001', 'namados' => 'Dr. Budi'],
            ['nid' => 'D002', 'namados' => 'Dr. Andi'],
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
        $this->assertSame('D001', $result[0]['nid']);
        $this->assertSame('Dr. Andi', $result[1]['namados']);
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
