<?php
session_start();
include 'includes/koneksi.php';

if(!isset($_SESSION['login'])){
    header('Location: login.php');
    exit;
}

$aksi = $_REQUEST['aksi'] ?? '';

// ========================
// TAMBAH
// ========================
if ($aksi === 'tambah') {
    $nim       = trim($_POST['nim'] ?? '');
    $namamhs   = trim($_POST['namamhs'] ?? '');
    $handphone = trim($_POST['handphone'] ?? '');

    if ($nim === '' || $namamhs === '') {
        $_SESSION['pesan'] = 'NIM dan Nama tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO tbl_mhs (nim, namamhs, handphone) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nim, $namamhs, $handphone);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = 'Data mahasiswa berhasil ditambahkan!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal menambahkan data.';
            $_SESSION['tipe']  = 'gagal';
        }
        mysqli_stmt_close($stmt);
    }
}

// ========================
// EDIT / UPDATE
// ========================
elseif ($aksi === 'edit') {
    $nim_lama  = trim($_POST['nim_lama'] ?? '');
    $nim       = trim($_POST['nim'] ?? '');
    $namamhs   = trim($_POST['namamhs'] ?? '');
    $handphone = trim($_POST['handphone'] ?? '');

    if ($nim === '' || $namamhs === '') {
        $_SESSION['pesan'] = 'NIM dan Nama tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE tbl_mhs SET nim=?, namamhs=?, handphone=? WHERE nim=?");
        mysqli_stmt_bind_param($stmt, "ssss", $nim, $namamhs, $handphone, $nim_lama);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = 'Data mahasiswa berhasil diupdate!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal update data.';
            $_SESSION['tipe']  = 'gagal';
        }
        mysqli_stmt_close($stmt);
    }
}

// ========================
// HAPUS
// ========================
elseif ($aksi === 'hapus') {
    $nim = trim($_GET['id'] ?? '');

    $stmt = mysqli_prepare($conn, "DELETE FROM tbl_mhs WHERE nim=?");
    mysqli_stmt_bind_param($stmt, "s", $nim);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['pesan'] = 'Data mahasiswa berhasil dihapus!';
        $_SESSION['tipe']  = 'sukses';
    } else {
        $_SESSION['pesan'] = 'Gagal hapus data.';
        $_SESSION['tipe']  = 'gagal';
    }
    mysqli_stmt_close($stmt);
}

// Redirect balik ke halaman mahasiswa
header('Location: mahasiswa.php');
exit;
