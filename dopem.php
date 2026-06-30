<?php
session_start();
include 'includes/koneksi.php';

// =====================
// PROSES CRUD
// =====================
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// TAMBAH
if ($aksi === 'tambah') {
    $nim       = trim($_POST['nim']);
    $namamhs   = trim($_POST['namamhs']);
    $nid       = trim($_POST['nid']);
    $namadosen = trim($_POST['namadosen']);

    if ($nim && $namamhs && $nid && $namadosen) {
        $nim       = mysqli_real_escape_string($conn, $nim);
        $namamhs   = mysqli_real_escape_string($conn, $namamhs);
        $nid       = mysqli_real_escape_string($conn, $nid);
        $namadosen = mysqli_real_escape_string($conn, $namadosen);

        $query = mysqli_query($conn,
            "INSERT INTO tbl_dopem (nim, namamhs, nid, namadosen)
             VALUES ('$nim', '$namamhs', '$nid', '$namadosen')"
        );

        $_SESSION['pesan'] = $query ? 'Data dosen pembimbing berhasil ditambahkan.' : 'Gagal menambahkan data: ' . mysqli_error($conn);
        $_SESSION['tipe']  = $query ? 'sukses' : 'gagal';
    } else {
        $_SESSION['pesan'] = 'Semua field wajib diisi.';
        $_SESSION['tipe']  = 'gagal';
    }
    header('Location: dopem.php');
    exit;
}

// EDIT
if ($aksi === 'edit') {
    $nim_lama  = mysqli_real_escape_string($conn, trim($_POST['nim_lama']));
    $nid_lama  = mysqli_real_escape_string($conn, trim($_POST['nid_lama']));
    $nim       = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $namamhs   = mysqli_real_escape_string($conn, trim($_POST['namamhs']));
    $nid       = mysqli_real_escape_string($conn, trim($_POST['nid']));
    $namadosen = mysqli_real_escape_string($conn, trim($_POST['namadosen']));

    if ($nim && $namamhs && $nid && $namadosen) {
        $query = mysqli_query($conn,
            "UPDATE tbl_dopem
             SET nim='$nim', namamhs='$namamhs', nid='$nid', namadosen='$namadosen'
             WHERE nim='$nim_lama' AND nid='$nid_lama'"
        );

        $_SESSION['pesan'] = $query ? 'Data dosen pembimbing berhasil diperbarui.' : 'Gagal memperbarui data: ' . mysqli_error($conn);
        $_SESSION['tipe']  = $query ? 'sukses' : 'gagal';
    } else {
        $_SESSION['pesan'] = 'Semua field wajib diisi.';
        $_SESSION['tipe']  = 'gagal';
    }
    header('Location: dopem.php');
    exit;
}

// HAPUS
if ($aksi === 'hapus') {
    $nim = mysqli_real_escape_string($conn, $_GET['nim'] ?? '');
    $nid = mysqli_real_escape_string($conn, $_GET['nid'] ?? '');

    if ($nim && $nid) {
        $query = mysqli_query($conn, "DELETE FROM tbl_dopem WHERE nim='$nim' AND nid='$nid'");
        $_SESSION['pesan'] = $query ? 'Data dosen pembimbing berhasil dihapus.' : 'Gagal menghapus data: ' . mysqli_error($conn);
        $_SESSION['tipe']  = $query ? 'sukses' : 'gagal';
    } else {
        $_SESSION['pesan'] = 'Data tidak ditemukan.';
        $_SESSION['tipe']  = 'gagal';
    }
    header('Location: dopem.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen Pembimbing</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/shared.css">
</head>
<body>

<div class="container-custom">

    <?php include 'includes/navbar.php'; ?>

    <?php include 'includes/notifikasi.php'; ?>

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h1>Data Dosen Pembimbing</h1>
            <p>Daftar dosen pembimbing mahasiswa.</p>
        </div>
        <button class="btn-tambah" onclick="bukaModal('modalTambah')">+ Tambah Dospem</button>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>NID</th>
                    <th>Nama Dosen</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tbl_dopem");
                while ($data = mysqli_fetch_assoc($query)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="td-id"><?= htmlspecialchars($data['nim']); ?></td>
                    <td class="td-nama"><?= htmlspecialchars($data['namamhs']); ?></td>
                    <td class="td-id"><?= htmlspecialchars($data['nid']); ?></td>
                    <td><?= htmlspecialchars($data['namadosen']); ?></td>
                    <td class="td-aksi">
                        <div class="aksi-wrap">
                            <button class="btn-edit"
                                onclick="bukaModalEdit(
                                    '<?= htmlspecialchars($data['nim'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($data['namamhs'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($data['nid'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($data['namadosen'], ENT_QUOTES) ?>'
                                )">
                                Edit
                            </button>
                            <a href="dopem.php?aksi=hapus&nim=<?= urlencode($data['nim']) ?>&nid=<?= urlencode($data['nid']) ?>"
                                onclick="return confirm('Yakin ingin hapus data dospem ini?')"
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
        <h2>Tambah Dosen Pembimbing</h2>
        <form action="dopem.php" method="POST">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group">
                <label>NIM Mahasiswa</label>
                <input type="text" name="nim" required placeholder="Contoh: 12345678">
            </div>
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="namamhs" required placeholder="Nama lengkap mahasiswa">
            </div>
            <div class="form-group">
                <label>NID Dosen</label>
                <input type="text" name="nid" required placeholder="Contoh: D001">
            </div>
            <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" name="namadosen" required placeholder="Nama lengkap dosen">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <h2>Edit Dosen Pembimbing</h2>
        <form action="dopem.php" method="POST">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="nim_lama" id="editNimLama">
            <input type="hidden" name="nid_lama" id="editNidLama">
            <div class="form-group">
                <label>NIM Mahasiswa</label>
                <input type="text" name="nim" id="editNim" required>
            </div>
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="namamhs" id="editNama" required>
            </div>
            <div class="form-group">
                <label>NID Dosen</label>
                <input type="text" name="nid" id="editNid" required>
            </div>
            <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" name="namadosen" id="editNamaDosen" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="js/modal.js"></script>
<script>
    function bukaModalEdit(nim, namamhs, nid, namadosen) {
        document.getElementById('editNimLama').value = nim;
        document.getElementById('editNidLama').value = nid;
        document.getElementById('editNim').value = nim;
        document.getElementById('editNama').value = namamhs;
        document.getElementById('editNid').value = nid;
        document.getElementById('editNamaDosen').value = namadosen;
        bukaModal('modalEdit');
    }
</script>

</body>
</html>
