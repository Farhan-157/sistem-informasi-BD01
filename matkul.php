<?php
session_start();
include 'includes/koneksi.php';

// Tambah data matkul
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_matkul'])) {
    $kode = mysqli_real_escape_string($conn, trim($_POST['kodemk']));
    $nama = mysqli_real_escape_string($conn, trim($_POST['namamk']));
    $sks  = mysqli_real_escape_string($conn, trim($_POST['sks']));
    mysqli_query($conn, "INSERT INTO tbl_matakuliah (kodemk, namamk, sks) VALUES ('$kode', '$nama', '$sks')");
    $_SESSION['pesan'] = 'Mata kuliah berhasil ditambahkan!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: matkul.php");
    exit;
}

// Edit data matkul
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_matkul'])) {
    $kode_lama = mysqli_real_escape_string($conn, trim($_POST['kodemk_lama']));
    $kode      = mysqli_real_escape_string($conn, trim($_POST['kodemk']));
    $nama      = mysqli_real_escape_string($conn, trim($_POST['namamk']));
    $sks       = mysqli_real_escape_string($conn, trim($_POST['sks']));
    mysqli_query($conn, "UPDATE tbl_matakuliah SET kodemk='$kode', namamk='$nama', sks='$sks' WHERE kodemk='$kode_lama'");
    $_SESSION['pesan'] = 'Mata kuliah berhasil diupdate!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: matkul.php");
    exit;
}

// Hapus data matkul
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {
    $kode = mysqli_real_escape_string($conn, trim($_GET['kodemk']));
    mysqli_query($conn, "DELETE FROM tbl_matakuliah WHERE kodemk='$kode'");
    $_SESSION['pesan'] = 'Mata kuliah berhasil dihapus!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: matkul.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/shared.css">
</head>
<body>

<div class="container-custom">

    <?php include 'includes/navbar.php'; ?>

    <?php include 'includes/notifikasi.php'; ?>

    <div class="page-header">
        <div>
            <h1>Mata Kuliah</h1>
            <p>Daftar manajemen mata kuliah semester ini.</p>
        </div>
        <button class="btn-tambah" onclick="bukaModal('modalTambah')">+ Tambah Matkul</button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th style="text-align:center;">SKS</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM tbl_matakuliah");
                while ($matkul = mysqli_fetch_assoc($query)) :
                ?>
                <tr>
                    <td class="td-id"><?= htmlspecialchars($matkul['kodemk']); ?></td>
                    <td class="td-nama"><?= htmlspecialchars($matkul['namamk']); ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($matkul['sks']); ?></td>
                    <td class="td-aksi">
                        <div class="aksi-wrap">
                            <button class="btn-edit"
                                onclick="bukaModalEdit('<?= htmlspecialchars($matkul['kodemk'], ENT_QUOTES) ?>', '<?= htmlspecialchars($matkul['namamk'], ENT_QUOTES) ?>', '<?= htmlspecialchars($matkul['sks'], ENT_QUOTES) ?>')">
                                Edit
                            </button>
                            <a href="matkul.php?aksi=hapus&kodemk=<?= urlencode($matkul['kodemk']) ?>"
                                onclick="return confirm('Yakin ingin hapus mata kuliah ini?')"
                                class="btn-hapus">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <h2>Tambah Mata Kuliah</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Kode Matkul</label>
                <input type="text" name="kodemk" required placeholder="Contoh: INF-103">
            </div>
            <div class="form-group">
                <label>Nama Mata Kuliah</label>
                <input type="text" name="namamk" required placeholder="Contoh: Pemrograman Web">
            </div>
            <div class="form-group">
                <label>SKS</label>
                <input type="number" name="sks" required placeholder="Contoh: 3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal('modalTambah')">Batal</button>
                <button type="submit" name="tambah_matkul" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <h2>Edit Mata Kuliah</h2>
        <form action="" method="POST">
            <input type="hidden" name="kodemk_lama" id="editKodeLama">
            <div class="form-group">
                <label>Kode Matkul</label>
                <input type="text" name="kodemk" id="editKode" required>
            </div>
            <div class="form-group">
                <label>Nama Mata Kuliah</label>
                <input type="text" name="namamk" id="editNama" required>
            </div>
            <div class="form-group">
                <label>SKS</label>
                <input type="number" name="sks" id="editSks" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal('modalEdit')">Batal</button>
                <button type="submit" name="edit_matkul" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="js/modal.js"></script>
<script>
    function bukaModalEdit(kode, nama, sks) {
        document.getElementById('editKodeLama').value = kode;
        document.getElementById('editKode').value = kode;
        document.getElementById('editNama').value = nama;
        document.getElementById('editSks').value = sks;
        bukaModal('modalEdit');
    }
</script>

</body>
</html>
