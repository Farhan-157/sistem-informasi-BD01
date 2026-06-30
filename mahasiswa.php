<?php
session_start();
include 'includes/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/shared.css">
</head>
<body>

<div class="container-custom">

    <?php include 'includes/navbar.php'; ?>

    <?php include 'includes/notifikasi.php'; ?>

    <div class="page-header">
        <div>
            <h1>Data Mahasiswa</h1>
            <p>Daftar data mahasiswa yang terdaftar.</p>
        </div>
        <button class="btn-tambah" onclick="bukaModal('modalTambah')">+ Tambah Mahasiswa</button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tbl_mhs");
                while ($data = mysqli_fetch_assoc($query)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="td-id"><?= htmlspecialchars($data['nim']); ?></td>
                    <td class="td-nama"><?= htmlspecialchars($data['namamhs']); ?></td>
                    <td><?= htmlspecialchars($data['handphone']); ?></td>
                    <td class="td-aksi">
                        <div class="aksi-wrap">
                            <button class="btn-edit"
                                onclick="bukaModalEdit('<?= htmlspecialchars($data['nim'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['namamhs'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['handphone'], ENT_QUOTES) ?>')">
                                Edit
                            </button>
                            <a href="mahasiswa_action.php?aksi=hapus&id=<?= urlencode($data['nim']) ?>"
                                onclick="return confirm('Yakin ingin hapus mahasiswa ini?')"
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
        <h2>Tambah Mahasiswa</h2>
        <form action="mahasiswa_action.php" method="POST">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" required placeholder="Contoh: 12345678">
            </div>
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="namamhs" required placeholder="Nama lengkap">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="handphone" placeholder="08xxxxxxxxxx">
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
        <h2>Edit Mahasiswa</h2>
        <form action="mahasiswa_action.php" method="POST">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="nim_lama" id="editNimLama">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" id="editNim" required>
            </div>
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="namamhs" id="editNama" required>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="handphone" id="editHp">
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
    function bukaModalEdit(nim, nama, hp) {
        document.getElementById('editNimLama').value = nim;
        document.getElementById('editNim').value = nim;
        document.getElementById('editNama').value = nama;
        document.getElementById('editHp').value = hp;
        bukaModal('modalEdit');
    }
</script>

</body>
</html>
