<?php
session_start();
include 'includes/koneksi.php';

$aksi = $_REQUEST['aksi'] ?? '';

// ========================
// TAMBAH
// ========================
if ($aksi === 'tambah') {
    $nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $namamhs  = mysqli_real_escape_string($conn, trim($_POST['namamhs']));
    $handphone = mysqli_real_escape_string($conn, trim($_POST['handphone']));

    if ($nim === '' || $namamhs === '') {
        $_SESSION['pesan'] = 'NIM dan Nama tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tbl_mhs (nim, namamhs, handphone) VALUES ('$nim', '$namamhs', '$handphone')");

        if ($query) {
            $_SESSION['pesan'] = 'Data mahasiswa berhasil ditambahkan!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal menambahkan data: ' . mysqli_error($conn);
            $_SESSION['tipe']  = 'gagal';
        }
    }
}

// ========================
// EDIT / UPDATE
// ========================
elseif ($aksi === 'edit') {
    $id       = intval($_POST['id']);
    $nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $namamhs  = mysqli_real_escape_string($conn, trim($_POST['namamhs']));
    $handphone = mysqli_real_escape_string($conn, trim($_POST['handphone']));

    if ($nim === '' || $namamhs === '') {
        $_SESSION['pesan'] = 'NIM dan Nama tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $query = mysqli_query($conn, "UPDATE tbl_mhs SET nim='$nim', namamhs='$namamhs', handphone='$handphone' WHERE id='$id'");

        if ($query) {
            $_SESSION['pesan'] = 'Data mahasiswa berhasil diupdate!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal update data: ' . mysqli_error($conn);
            $_SESSION['tipe']  = 'gagal';
        }
    }
}

// ========================
// HAPUS
// ========================
elseif ($aksi === 'hapus') {
    $id = intval($_GET['id']);

    $query = mysqli_query($conn, "DELETE FROM tbl_mhs WHERE id='$id'");

    if ($query) {
        $_SESSION['pesan'] = 'Data mahasiswa berhasil dihapus!';
        $_SESSION['tipe']  = 'sukses';
    } else {
        $_SESSION['pesan'] = 'Gagal hapus data: ' . mysqli_error($conn);
        $_SESSION['tipe']  = 'gagal';
    }
}

// Redirect balik ke halaman mahasiswa
header('Location: mahasiswa.php');
exit;