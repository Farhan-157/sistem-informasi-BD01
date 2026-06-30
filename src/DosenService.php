<?php

namespace App;

class DosenService
{
    private DatabaseWrapper $db;

    public function __construct(DatabaseWrapper $db)
    {
        $this->db = $db;
    }

    public function tambah(string $nid, string $namados): array
    {
        $nid = Validator::sanitize($nid);
        $namados = Validator::sanitize($namados);

        if (!Validator::isNotEmpty($nid) || !Validator::isNotEmpty($namados)) {
            return [
                'success' => false,
                'pesan' => 'NID dan Nama Dosen tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateNid($nid)) {
            return [
                'success' => false,
                'pesan' => 'Format NID tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        $nidEsc = $this->db->escapeString($nid);
        $namaEsc = $this->db->escapeString($namados);

        $result = $this->db->query(
            "INSERT INTO tbl_dosen (nid, namados) VALUES ('$nidEsc', '$namaEsc')"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data dosen berhasil ditambahkan!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal menambahkan data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function edit(string $nidLama, string $nid, string $namados): array
    {
        $nidLama = Validator::sanitize($nidLama);
        $nid = Validator::sanitize($nid);
        $namados = Validator::sanitize($namados);

        if (!Validator::isNotEmpty($nid) || !Validator::isNotEmpty($namados)) {
            return [
                'success' => false,
                'pesan' => 'NID dan Nama Dosen tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        if (!Validator::validateNid($nid)) {
            return [
                'success' => false,
                'pesan' => 'Format NID tidak valid!',
                'tipe' => 'gagal',
            ];
        }

        $nidLamaEsc = $this->db->escapeString($nidLama);
        $nidEsc = $this->db->escapeString($nid);
        $namaEsc = $this->db->escapeString($namados);

        $result = $this->db->query(
            "UPDATE tbl_dosen SET nid='$nidEsc', namados='$namaEsc' WHERE nid='$nidLamaEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data dosen berhasil diupdate!',
                'tipe' => 'sukses',
            ];
        }

        return [
            'success' => false,
            'pesan' => 'Gagal update data: ' . $this->db->error(),
            'tipe' => 'gagal',
        ];
    }

    public function hapus(string $nid): array
    {
        $nid = Validator::sanitize($nid);

        if (!Validator::isNotEmpty($nid)) {
            return [
                'success' => false,
                'pesan' => 'NID tidak boleh kosong!',
                'tipe' => 'gagal',
            ];
        }

        $nidEsc = $this->db->escapeString($nid);

        $result = $this->db->query(
            "DELETE FROM tbl_dosen WHERE nid='$nidEsc'"
        );

        if ($result) {
            return [
                'success' => true,
                'pesan' => 'Data dosen berhasil dihapus!',
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
        $result = $this->db->query("SELECT * FROM tbl_dosen");
        $data = [];

        if ($result) {
            while ($row = $this->db->fetchAssoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
