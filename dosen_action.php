<?php
session_start();
include 'includes/koneksi.php';
include 'includes/flash.php';

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi === 'tambah') {
    $nid     = mysqli_real_escape_string($conn, trim($_POST['nid']));
    $namados = mysqli_real_escape_string($conn, trim($_POST['namados']));

    if ($nid === '' || $namados === '') {
        set_flash('NID dan Nama Dosen tidak boleh kosong!', 'gagal');
    } else {
        $query = mysqli_query($conn, "INSERT INTO tbl_dosen (nid, namados) VALUES ('$nid', '$namados')");

        if ($query) {
            set_flash('Data dosen berhasil ditambahkan!');
        } else {
            set_flash('Gagal menambahkan data: ' . mysqli_error($conn), 'gagal');
        }
    }
}

elseif ($aksi === 'edit') {
    $nid_lama = mysqli_real_escape_string($conn, trim($_POST['nid_lama']));
    $nid      = mysqli_real_escape_string($conn, trim($_POST['nid']));
    $namados  = mysqli_real_escape_string($conn, trim($_POST['namados']));

    if ($nid === '' || $namados === '') {
        set_flash('NID dan Nama Dosen tidak boleh kosong!', 'gagal');
    } else {
        $query = mysqli_query($conn, "UPDATE tbl_dosen SET nid='$nid', namados='$namados' WHERE nid='$nid_lama'");

        if ($query) {
            set_flash('Data dosen berhasil diupdate!');
        } else {
            set_flash('Gagal update data: ' . mysqli_error($conn), 'gagal');
        }
    }
}

elseif ($aksi === 'hapus') {
    $nid = mysqli_real_escape_string($conn, trim($_GET['nid']));

    $query = mysqli_query($conn, "DELETE FROM tbl_dosen WHERE nid='$nid'");

    if ($query) {
        set_flash('Data dosen berhasil dihapus!');
    } else {
        set_flash('Gagal hapus data: ' . mysqli_error($conn), 'gagal');
    }
}

header('Location: dosen.php');
exit;
