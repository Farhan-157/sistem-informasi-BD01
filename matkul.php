<?php
session_start();
include 'includes/koneksi.php';

// Tambah data matkul
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_matkul'])) {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $kode = trim($_POST['kodemk'] ?? '');
    $nama = trim($_POST['namamk'] ?? '');
    $sks  = trim($_POST['sks'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO tbl_matakuliah (kodemk, namamk, sks) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $kode, $nama, $sks);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['pesan'] = 'Mata kuliah berhasil ditambahkan!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: matkul.php");
    exit;
}

// Edit data matkul
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_matkul'])) {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $kode_lama = trim($_POST['kodemk_lama'] ?? '');
    $kode      = trim($_POST['kodemk'] ?? '');
    $nama      = trim($_POST['namamk'] ?? '');
    $sks       = trim($_POST['sks'] ?? '');
    $stmt = mysqli_prepare($conn, "UPDATE tbl_matakuliah SET kodemk=?, namamk=?, sks=? WHERE kodemk=?");
    mysqli_stmt_bind_param($stmt, "ssss", $kode, $nama, $sks, $kode_lama);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['pesan'] = 'Mata kuliah berhasil diupdate!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: matkul.php");
    exit;
}

// Hapus data matkul
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $kode = trim($_GET['kodemk'] ?? '');
    $stmt = mysqli_prepare($conn, "DELETE FROM tbl_matakuliah WHERE kodemk=?");
    mysqli_stmt_bind_param($stmt, "s", $kode);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: url('img/hero.jpg') center/cover fixed;
            padding: 40px;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .container-custom {
            max-width: 1200px;
            margin: auto;
            background: transparent;
            padding: 25px;
            position: relative;
            z-index: 1;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .logo { font-size: 28px; font-weight: 600; color: white; }
        .nav-links { display: flex; gap: 35px; }
        .nav-links a { text-decoration: none; color: white; font-size: 15px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #93c5fd; }

        .btn-book {
            background: #0f172a;
            color: white;
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-book:hover { background: #1e293b; }

        .notif-sukses {
            margin-bottom: 16px; padding: 12px 16px; border-radius: 10px;
            font-size: 14px; font-weight: 500;
            background: #dcfce7; color: #15803d; border: 1px solid #86efac;
        }
        .notif-gagal {
            margin-bottom: 16px; padding: 12px 16px; border-radius: 10px;
            font-size: 14px; font-weight: 500;
            background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;
        }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: white; }
        .page-header p { font-size: 14px; color: rgba(255,255,255,0.7); margin-top: 4px; }

        .btn-tambah {
            background: #2563eb; color: white; padding: 10px 22px;
            border-radius: 12px; font-size: 14px; font-weight: 500;
            border: none; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;
        }
        .btn-tambah:hover { background: #1d4ed8; }

        .table-wrapper {
            background: transparent;
            border-radius: 16px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead tr { background: rgba(0,0,0,0.35); border-bottom: 1px solid rgba(255,255,255,0.15); }
        th { padding: 16px 24px; font-size: 13px; font-weight: 600; color: white; text-transform: uppercase; letter-spacing: 0.05em; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.1); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(0,0,0,0.25); }
        td { padding: 16px 24px; font-size: 14px; color: white; }

        .td-kode { font-family: monospace; font-size: 13px; color: #a5b4fc; font-weight: 600; }
        .td-nama { font-weight: 500; color: white; }
        .td-aksi { text-align: center; }
        .aksi-wrap { display: flex; gap: 8px; justify-content: center; }

        .btn-edit {
            background: #fbbf24; color: white; border: none;
            padding: 6px 16px; border-radius: 8px; font-size: 12px;
            font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;
        }
        .btn-edit:hover { background: #f59e0b; }

        .btn-hapus {
            background: #ef4444; color: white; text-decoration: none;
            padding: 6px 16px; border-radius: 8px; font-size: 12px;
            font-weight: 600; transition: 0.3s; display: inline-block;
        }
        .btn-hapus:hover { background: #dc2626; }

        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 50;
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }

        .modal-box {
            background: white; border-radius: 20px; padding: 30px;
            width: 100%; max-width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        .modal-box h2 { font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 20px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-group input {
            width: 100%; border: 1px solid #d1d5db; border-radius: 10px;
            padding: 10px 14px; font-size: 14px; font-family: 'Poppins', sans-serif;
            transition: 0.2s; outline: none;
        }
        .form-group input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }

        .modal-footer { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; }

        .btn-batal {
            padding: 10px 20px; border-radius: 10px; border: 1px solid #d1d5db;
            background: white; font-size: 13px; color: #374151;
            cursor: pointer; transition: 0.2s; font-family: 'Poppins', sans-serif;
        }
        .btn-batal:hover { background: #f9fafb; }

        .btn-simpan {
            padding: 10px 20px; border-radius: 10px; border: none;
            background: #2563eb; color: white; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: 0.2s; font-family: 'Poppins', sans-serif;
        }
        .btn-simpan:hover { background: #1d4ed8; }

        .btn-update {
            padding: 10px 20px; border-radius: 10px; border: none;
            background: #f59e0b; color: white; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: 0.2s; font-family: 'Poppins', sans-serif;
        }
        .btn-update:hover { background: #d97706; }

        @media(max-width: 900px) {
            body { padding: 20px; }
            .navbar { flex-direction: column; gap: 16px; }
            .nav-links { flex-wrap: wrap; justify-content: center; }
            .page-header { flex-direction: column; gap: 12px; align-items: flex-start; }
            th, td { padding: 12px 14px; }
        }
    </style>
</head>
<body>

<div class="container-custom">

    <div class="navbar">
        <div class="logo">BASIS DATA 01</div>
         <div class="nav-links">
            <a href="index.php">Beranda</a>
            <a href="mahasiswa.php">Mahasiswa</a>
            <a href="dosen.php">Dosen</a>
            <a href="dopem.php">Dospem</a>
            <a href="matkul.php">Mata Kuliah</a>
            <a href="nilai.php">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>
        <a href="index.php" class="btn-book">Kembali ke Dashboard</a>
    </div>
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="<?= $_SESSION['tipe'] === 'sukses' ? 'notif-sukses' : 'notif-gagal' ?>">
            <?= htmlspecialchars($_SESSION['pesan']); ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

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
                    <td class="td-kode"><?= htmlspecialchars($matkul['kodemk']); ?></td>
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

<script>
    function bukaModal(idModal) {
        document.getElementById(idModal).classList.add('active');
    }
    function bukaModalEdit(kode, nama, sks) {
        document.getElementById('editKodeLama').value = kode;
        document.getElementById('editKode').value = kode;
        document.getElementById('editNama').value = nama;
        document.getElementById('editSks').value = sks;
        document.getElementById('modalEdit').classList.add('active');
    }
    function tutupModal(idModal) {
        document.getElementById(idModal).classList.remove('active');
    }
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });
</script>

</body>
</html>