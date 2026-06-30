<?php
session_start();
include 'includes/koneksi.php';

if(!isset($_SESSION['login'])){
    header('Location: login.php');
    exit;
}

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi === 'tambah') {
    $nid     = trim($_POST['nid'] ?? '');
    $namados = trim($_POST['namados'] ?? '');

    if ($nid === '' || $namados === '') {
        $_SESSION['pesan'] = 'NID dan Nama Dosen tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO tbl_dosen (nid, namados) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $nid, $namados);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = 'Data dosen berhasil ditambahkan!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal menambahkan data.';
            $_SESSION['tipe']  = 'gagal';
        }
        mysqli_stmt_close($stmt);
    }
}

elseif ($aksi === 'edit') {
    $nid_lama = trim($_POST['nid_lama'] ?? '');
    $nid      = trim($_POST['nid'] ?? '');
    $namados  = trim($_POST['namados'] ?? '');

    if ($nid === '' || $namados === '') {
        $_SESSION['pesan'] = 'NID dan Nama Dosen tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE tbl_dosen SET nid=?, namados=? WHERE nid=?");
        mysqli_stmt_bind_param($stmt, "sss", $nid, $namados, $nid_lama);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = 'Data dosen berhasil diupdate!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal update data.';
            $_SESSION['tipe']  = 'gagal';
        }
        mysqli_stmt_close($stmt);
    }
}

elseif ($aksi === 'hapus') {
    $nid = trim($_GET['nid'] ?? '');

    $stmt = mysqli_prepare($conn, "DELETE FROM tbl_dosen WHERE nid=?");
    mysqli_stmt_bind_param($stmt, "s", $nid);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['pesan'] = 'Data dosen berhasil dihapus!';
        $_SESSION['tipe']  = 'sukses';
    } else {
        $_SESSION['pesan'] = 'Gagal hapus data.';
        $_SESSION['tipe']  = 'gagal';
    }
    mysqli_stmt_close($stmt);
}

header('Location: dosen.php');
exit;
