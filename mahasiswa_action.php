<?php
session_start();
include 'includes/koneksi.php';
include 'includes/flash.php';

$aksi = $_REQUEST['aksi'] ?? '';

// ========================
// TAMBAH
// ========================
if ($aksi === 'tambah') {
    $nim       = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $namamhs   = mysqli_real_escape_string($conn, trim($_POST['namamhs']));
    $handphone = mysqli_real_escape_string($conn, trim($_POST['handphone']));

    if ($nim === '' || $namamhs === '') {
        set_flash('NIM dan Nama tidak boleh kosong!', 'gagal');
    } else {
        $query = mysqli_query($conn, "INSERT INTO tbl_mhs (nim, namamhs, handphone) VALUES ('$nim', '$namamhs', '$handphone')");

        if ($query) {
            set_flash('Data mahasiswa berhasil ditambahkan!');
        } else {
            set_flash('Gagal menambahkan data: ' . mysqli_error($conn), 'gagal');
        }
    }
}

// ========================
// EDIT / UPDATE
// ========================
elseif ($aksi === 'edit') {
    $nim_lama  = mysqli_real_escape_string($conn, trim($_POST['nim_lama']));
    $nim       = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $namamhs   = mysqli_real_escape_string($conn, trim($_POST['namamhs']));
    $handphone = mysqli_real_escape_string($conn, trim($_POST['handphone']));

    if ($nim === '' || $namamhs === '') {
        set_flash('NIM dan Nama tidak boleh kosong!', 'gagal');
    } else {
        $query = mysqli_query($conn, "UPDATE tbl_mhs SET nim='$nim', namamhs='$namamhs', handphone='$handphone' WHERE nim='$nim_lama'");

        if ($query) {
            set_flash('Data mahasiswa berhasil diupdate!');
        } else {
            set_flash('Gagal update data: ' . mysqli_error($conn), 'gagal');
        }
    }
}

// ========================
// HAPUS
// ========================
elseif ($aksi === 'hapus') {
    $nim = mysqli_real_escape_string($conn, trim($_GET['id']));

    $query = mysqli_query($conn, "DELETE FROM tbl_mhs WHERE nim='$nim'");

    if ($query) {
        set_flash('Data mahasiswa berhasil dihapus!');
    } else {
        set_flash('Gagal hapus data: ' . mysqli_error($conn), 'gagal');
    }
}

header('Location: mahasiswa.php');
exit;
