<?php

namespace App;

class MatkulService
{
    private DatabaseWrapper $db;

    public function __construct(DatabaseWrapper $db)
    {
        $this->db = $db;
    }

    public function tambah(string $kodemk, string $namamk, string $sks): array
    {
        $kodemk = Validator::sanitize($kodemk);
        $namamk = Validator::sanitize($namamk);
        $sks = Validator::sanitize($sks);

        if (!Validator::isNotEmpty($kodemk) || !Validator::isNotEmpty($namamk) || !Validator::isNotEmpty($sks)) {
            return [
                'success' => false,
                'pesan' => 'Kode MK, Nama MK, dan SKS tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateKodeMk($kodemk)) {
            return [
                'success' => false,
                'pesan' => 'Format Kode MK tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateSks($sks)) {
            return [
                'success' => false,
                'pesan' => 'SKS harus berupa angka antara 1-8!',
                'tipe' => 'gagal',
            ];
        }

        $kodeEsc = $this->db->escapeString($kodemk);
        $namaEsc = $this->db->escapeString($namamk);
        $sksEsc = $this->db->escapeString($sks);

        $result = $this->db->query(
            "INSERT INTO tbl_matakuliah (kodemk, namamk, sks) VALUES ('$kodeEsc', '$namaEsc', '$sksEsc')"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Mata kuliah berhasil ditambahkan!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal menambahkan data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function edit(string $kodeLama, string $kodemk, string $namamk, string $sks): array
    {
        $kodeLama = Validator::sanitize($kodeLama);
        $kodemk = Validator::sanitize($kodemk);
        $namamk = Validator::sanitize($namamk);
        $sks = Validator::sanitize($sks);

        if (!Validator::isNotEmpty($kodemk) || !Validator::isNotEmpty($namamk) || !Validator::isNotEmpty($sks)) {
            return [
                'success' => false,
                'pesan' => 'Kode MK, Nama MK, dan SKS tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateKodeMk($kodemk)) {
            return [
                'success' => false,
                'pesan' => 'Format Kode MK tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateSks($sks)) {
            return [
                'success' => false,
                'pesan' => 'SKS harus berupa angka antara 1-8!',
                'tipe' => 'gagal',
            ];
        }

        $kodeLamaEsc = $this->db->escapeString($kodeLama);
        $kodeEsc = $this->db->escapeString($kodemk);
        $namaEsc = $this->db->escapeString($namamk);
        $sksEsc = $this->db->escapeString($sks);

        $result = $this->db->query(
            "UPDATE tbl_matakuliah SET kodemk='$kodeEsc', namamk='$namaEsc', sks='$sksEsc' WHERE kodemk='$kodeLamaEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Mata kuliah berhasil diupdate!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal update data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function hapus(string $kodemk): array
    {
        $kodemk = Validator::sanitize($kodemk);

        if (!Validator::isNotEmpty($kodemk)) {
            return [
                'success' => false,
                'pesan' => 'Kode MK tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        $kodeEsc = $this->db->escapeString($kodemk);

        $result = $this->db->query(
            "DELETE FROM tbl_matakuliah WHERE kodemk='$kodeEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Mata kuliah berhasil dihapus!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal hapus data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM tbl_matakuliah");
        $data = [];

        if ($result) {
            while ($row = $this->db->fetchAssoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
