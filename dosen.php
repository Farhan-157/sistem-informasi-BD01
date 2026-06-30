<?php
session_start();
include 'includes/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/shared.css">
</head>
<body>

<div class="container-custom">

    <?php include 'includes/navbar.php'; ?>

    <?php include 'includes/notifikasi.php'; ?>

    <div class="page-header">
        <div>
            <h1>Data Dosen</h1>
            <p>Daftar data dosen yang terdaftar.</p>
        </div>
        <button class="btn-tambah" onclick="bukaModal('modalTambah')">+ Tambah Dosen</button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NID</th>
                    <th>Nama Dosen</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($conn, "SELECT * FROM tbl_dosen");
                while($row = mysqli_fetch_array($data)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="td-id"><?= htmlspecialchars($row['nid']); ?></td>
                    <td class="td-nama"><?= htmlspecialchars($row['namados']); ?></td>
                    <td class="td-aksi">
                        <div class="aksi-wrap">
                            <button class="btn-edit"
                                onclick="bukaModalEdit('<?= htmlspecialchars($row['nid'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['namados'], ENT_QUOTES) ?>')">
                                Edit
                            </button>
                            <a href="dosen_action.php?aksi=hapus&nid=<?= urlencode($row['nid']) ?>"
                                onclick="return confirm('Yakin ingin hapus dosen ini?')"
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
        <h2>Tambah Dosen</h2>
        <form action="dosen_action.php" method="POST">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group">
                <label>NID</label>
                <input type="text" name="nid" required placeholder="Contoh: D001">
            </div>
            <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" name="namados" required placeholder="Nama lengkap dosen">
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
        <h2>Edit Dosen</h2>
        <form action="dosen_action.php" method="POST">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="nid_lama" id="editNidLama">
            <div class="form-group">
                <label>NID</label>
                <input type="text" name="nid" id="editNid" required>
            </div>
            <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" name="namados" id="editNama" required>
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
    function bukaModalEdit(nid, nama) {
        document.getElementById('editNidLama').value = nid;
        document.getElementById('editNid').value = nid;
        document.getElementById('editNama').value = nama;
        bukaModal('modalEdit');
    }
</script>

</body>
</html>
