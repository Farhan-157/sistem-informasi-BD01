<?php
session_start();
include 'includes/koneksi.php';

// TAMBAH
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_nilai'])) {
    $nim    = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $tugas  = mysqli_real_escape_string($conn, trim($_POST['tugas']));
    $uts    = mysqli_real_escape_string($conn, trim($_POST['uts']));
    $uas    = mysqli_real_escape_string($conn, trim($_POST['uas']));
    $akhir  = mysqli_real_escape_string($conn, trim($_POST['akhir']));
    $hm     = mysqli_real_escape_string($conn, trim($_POST['hm']));
    $status = mysqli_real_escape_string($conn, trim($_POST['status']));

    mysqli_query($conn, "INSERT INTO tbl_nilai (nim, tugas, uts, uas, akhir, hm, status) VALUES ('$nim', '$tugas', '$uts', '$uas', '$akhir', '$hm', '$status')");
    $_SESSION['pesan'] = 'Nilai berhasil ditambahkan!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: nilai.php");
    exit;
}

// EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_nilai'])) {
    $nim_lama = mysqli_real_escape_string($conn, trim($_POST['nim_lama']));
    $nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $tugas    = mysqli_real_escape_string($conn, trim($_POST['tugas']));
    $uts      = mysqli_real_escape_string($conn, trim($_POST['uts']));
    $uas      = mysqli_real_escape_string($conn, trim($_POST['uas']));
    $akhir    = mysqli_real_escape_string($conn, trim($_POST['akhir']));
    $hm       = mysqli_real_escape_string($conn, trim($_POST['hm']));
    $status   = mysqli_real_escape_string($conn, trim($_POST['status']));

    mysqli_query($conn, "UPDATE tbl_nilai SET nim='$nim', tugas='$tugas', uts='$uts', uas='$uas', akhir='$akhir', hm='$hm', status='$status' WHERE nim='$nim_lama'");
    $_SESSION['pesan'] = 'Nilai berhasil diupdate!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: nilai.php");
    exit;
}

// HAPUS
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {
    $nim = mysqli_real_escape_string($conn, trim($_GET['nim']));
    mysqli_query($conn, "DELETE FROM tbl_nilai WHERE nim='$nim'");
    $_SESSION['pesan'] = 'Nilai berhasil dihapus!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: nilai.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            min-height: 100vh;
            background-image: url('img/hero.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            padding: 40px;
        }

        .container-custom { max-width: 1200px; margin: auto; }

        /* NAVBAR */
        .navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.15); }
        .logo { font-size: 28px; font-weight: 700; color: #ffffff; letter-spacing: 1px; }
        .nav-links { display: flex; gap: 35px; }
        .nav-links a { text-decoration: none; color: rgba(255,255,255,0.75); font-size: 15px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #ffffff; }
        .btn-book { background: #0f172a; color: white; padding: 12px 28px; border-radius: 30px; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .btn-book:hover { background: #1e293b; }

        /* TABLE */
        .table-card {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            overflow: hidden;
        }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card thead tr {
            background: rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .table-card thead th {
            padding: 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.6);
            text-align: center;
        }
        .table-card thead th:nth-child(2) { text-align: left; }
        .table-card tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.06);
            transition: background 0.15s;
        }
        .table-card tbody tr:hover { background: rgba(255,255,255,0.06); }
        .table-card tbody tr:last-child { border-bottom: none; }
        .table-card tbody td {
            padding: 16px;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            text-align: center;
        }
        .table-card tbody td:nth-child(2) { text-align: left; }
        .td-nim { color: #818cf8 !important; font-family: monospace; font-weight: 600; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 50; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; border-radius: 20px; width: 100%; max-width: 520px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto; }
    </style>
</head>
<body>

<div class="page-wrapper">
<div class="container-custom">

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="logo">BASIS DATA 01</div>
        <div class="nav-links">
            <a href="index.php">Beranda</a>
            <a href="mahasiswa.php">Mahasiswa</a>
            <a href="dosen.php">Dosen</a>
            <a href="matkul.php">Mata Kuliah</a>
            <a href="nilai.php" class="active">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>
        <a href="index.php" class="btn-book">Kembali ke Dashboard</a>
    </div>

    <!-- NOTIFIKASI -->
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium
            <?= $_SESSION['tipe'] === 'sukses' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?>">
            <?= $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Nilai Mahasiswa</h1>
            <p class="text-sm text-slate-300 mt-1">Transkrip dan rekapitulasi nilai mahasiswa berdasarkan mata kuliah.</p>
        </div>
        <button onclick="bukaModal('modalTambah')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
            + Tambah Nilai
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Akhir</th>
                    <th>HM</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tbl_nilai");
                while ($row = mysqli_fetch_assoc($query)) :
                    $status = $row['status'];
                    $statusClass = 'bg-emerald-100 text-emerald-800';
                    $hmClass = strtolower($row['hm']) === 'a' ? 'text-emerald-400 font-bold' : 'text-white font-bold';
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="td-nim"><?= htmlspecialchars($row['nim']); ?></td>
                    <td><?= htmlspecialchars($row['tugas']); ?></td>
                    <td><?= htmlspecialchars($row['uts']); ?></td>
                    <td><?= htmlspecialchars($row['uas']); ?></td>
                    <td class="font-semibold"><?= htmlspecialchars($row['akhir']); ?></td>
                    <td class="<?= $hmClass ?>"><?= htmlspecialchars($row['hm']); ?></td>
                    <td>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                            <?= htmlspecialchars($status); ?>
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2 justify-center">
                            <button
                                onclick="bukaModalEdit('<?= htmlspecialchars($row['nim'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['tugas'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['uts'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['uas'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['akhir'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['hm'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['status'], ENT_QUOTES) ?>')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Edit
                            </button>
                            <a href="nilai.php?aksi=hapus&nim=<?= urlencode($row['nim']) ?>"
                                onclick="return confirm('Yakin ingin hapus nilai ini?')"
                                class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Tambah Nilai</h3>
            <button onclick="tutupModal('modalTambah')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">NIM</label>
                <input type="text" name="nim" required placeholder="Contoh: 22010011"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tugas</label>
                    <input type="number" name="tugas" min="0" max="100" placeholder="0-100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">UTS</label>
                    <input type="number" name="uts" min="0" max="100" placeholder="0-100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">UAS</label>
                    <input type="number" name="uas" min="0" max="100" placeholder="0-100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nilai Akhir</label>
                    <input type="number" name="akhir" min="0" max="100" placeholder="0-100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Huruf (HM)</label>
                    <select name="hm" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="Lulus">Lulus</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="tutupModal('modalTambah')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" name="tambah_nilai"
                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Edit Nilai</h3>
            <button onclick="tutupModal('modalEdit')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="nim_lama" id="editNimLama">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">NIM</label>
                <input type="text" name="nim" id="editNim" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tugas</label>
                    <input type="number" name="tugas" id="editTugas" min="0" max="100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">UTS</label>
                    <input type="number" name="uts" id="editUts" min="0" max="100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">UAS</label>
                    <input type="number" name="uas" id="editUas" min="0" max="100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nilai Akhir</label>
                    <input type="number" name="akhir" id="editAkhir" min="0" max="100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Huruf (HM)</label>
                    <select name="hm" id="editHm" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" id="editStatus" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                        <option value="Lulus">Lulus</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="tutupModal('modalEdit')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" name="edit_nilai"
                    class="px-5 py-2 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold transition">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function bukaModalEdit(nim, tugas, uts, uas, akhir, hm, status) {
        document.getElementById('editNimLama').value = nim;
        document.getElementById('editNim').value     = nim;
        document.getElementById('editTugas').value   = tugas;
        document.getElementById('editUts').value     = uts;
        document.getElementById('editUas').value     = uas;
        document.getElementById('editAkhir').value   = akhir;
        document.getElementById('editHm').value      = hm;
        document.getElementById('editStatus').value  = status;
        document.getElementById('modalEdit').classList.add('active');
    }

    function tutupModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });
</script>

</body>
</html>