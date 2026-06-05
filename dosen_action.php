<?php
session_start();
include 'includes/koneksi.php';

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi === 'tambah') {
    $nid     = mysqli_real_escape_string($conn, trim($_POST['nid']));
    $namados = mysqli_real_escape_string($conn, trim($_POST['namados']));

    if ($nid === '' || $namados === '') {
        $_SESSION['pesan'] = 'NID dan Nama Dosen tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tbl_dosen (nid, namados) VALUES ('$nid', '$namados')");

        if ($query) {
            $_SESSION['pesan'] = 'Data dosen berhasil ditambahkan!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal menambahkan data: ' . mysqli_error($conn);
            $_SESSION['tipe']  = 'gagal';
        }
    }
}

elseif ($aksi === 'edit') {
    $nid_lama = mysqli_real_escape_string($conn, trim($_POST['nid_lama']));
    $nid      = mysqli_real_escape_string($conn, trim($_POST['nid']));
    $namados  = mysqli_real_escape_string($conn, trim($_POST['namados']));

    if ($nid === '' || $namados === '') {
        $_SESSION['pesan'] = 'NID dan Nama Dosen tidak boleh kosong!';
        $_SESSION['tipe']  = 'gagal';
    } else {
        $query = mysqli_query($conn, "UPDATE tbl_dosen SET nid='$nid', namados='$namados' WHERE nid='$nid_lama'");

        if ($query) {
            $_SESSION['pesan'] = 'Data dosen berhasil diupdate!';
            $_SESSION['tipe']  = 'sukses';
        } else {
            $_SESSION['pesan'] = 'Gagal update data: ' . mysqli_error($conn);
            $_SESSION['tipe']  = 'gagal';
        }
    }
}

elseif ($aksi === 'hapus') {
    $nid = mysqli_real_escape_string($conn, trim($_GET['nid']));

    $query = mysqli_query($conn, "DELETE FROM tbl_dosen WHERE nid='$nid'");

    if ($query) {
        $_SESSION['pesan'] = 'Data dosen berhasil dihapus!';
        $_SESSION['tipe']  = 'sukses';
    } else {
        $_SESSION['pesan'] = 'Gagal hapus data: ' . mysqli_error($conn);
        $_SESSION['tipe']  = 'gagal';
    }
}

header('Location: dosen.php');
exit;