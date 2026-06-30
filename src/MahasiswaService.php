<?php

namespace App;

class MahasiswaService
{
    private DatabaseWrapper $db;

    public function __construct(DatabaseWrapper $db)
    {
        $this->db = $db;
    }

    public function tambah(string $nim, string $namamhs, string $handphone = ''): array
    {
        $nim = Validator::sanitize($nim);
        $namamhs = Validator::sanitize($namamhs);
        $handphone = Validator::sanitize($handphone);

        if (!Validator::isNotEmpty($nim) || !Validator::isNotEmpty($namamhs)) {
            return [
                'success' => false,
                'pesan' => 'NIM dan Nama tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateNim($nim)) {
            return [
                'success' => false,
                'pesan' => 'Format NIM tidak valid! Hanya angka yang diperbolehkan.',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validatePhone($handphone)) {
            return [
                'success' => false,
                'pesan' => 'Format nomor HP tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        $nimEsc = $this->db->escapeString($nim);
        $namaEsc = $this->db->escapeString($namamhs);
        $hpEsc = $this->db->escapeString($handphone);

        $result = $this->db->query(
            "INSERT INTO tbl_mhs (nim, namamhs, handphone) VALUES ('$nimEsc', '$namaEsc', '$hpEsc')"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data mahasiswa berhasil ditambahkan!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal menambahkan data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function edit(string $nimLama, string $nim, string $namamhs, string $handphone = ''): array
    {
        $nimLama = Validator::sanitize($nimLama);
        $nim = Validator::sanitize($nim);
        $namamhs = Validator::sanitize($namamhs);
        $handphone = Validator::sanitize($handphone);

        if (!Validator::isNotEmpty($nim) || !Validator::isNotEmpty($namamhs)) {
            return [
                'success' => false,
                'pesan' => 'NIM dan Nama tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateNim($nim)) {
            return [
                'success' => false,
                'pesan' => 'Format NIM tidak valid! Hanya angka yang diperbolehkan.',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validatePhone($handphone)) {
            return [
                'success' => false,
                'pesan' => 'Format nomor HP tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        $nimLamaEsc = $this->db->escapeString($nimLama);
        $nimEsc = $this->db->escapeString($nim);
        $namaEsc = $this->db->escapeString($namamhs);
        $hpEsc = $this->db->escapeString($handphone);

        $result = $this->db->query(
            "UPDATE tbl_mhs SET nim='$nimEsc', namamhs='$namaEsc', handphone='$hpEsc' WHERE nim='$nimLamaEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data mahasiswa berhasil diupdate!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal update data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function hapus(string $nim): array
    {
        $nim = Validator::sanitize($nim);

        if (!Validator::isNotEmpty($nim)) {
            return [
                'success' => false,
                'pesan' => 'NIM tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        $nimEsc = $this->db->escapeString($nim);

        $result = $this->db->query(
            "DELETE FROM tbl_mhs WHERE nim='$nimEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data mahasiswa berhasil dihapus!',
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
        $result = $this->db->query("SELECT * FROM tbl_mhs");
        $data = [];

        if ($result) {
            while ($row = $this->db->fetchAssoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
