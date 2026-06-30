<?php
session_start();
include 'includes/koneksi.php';

// TAMBAH
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_anggota'])) {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $nim     = trim($_POST['nim'] ?? '');
    $nama    = trim($_POST['nama'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $no_hp   = trim($_POST['no_hp'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');

    $stmt = mysqli_prepare($conn, "INSERT INTO tbl_anggota (nim, nama, email, no_hp, jabatan) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nim, $nama, $email, $no_hp, $jabatan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['pesan'] = 'Data anggota berhasil ditambahkan!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: anggota.php");
    exit;
}

// EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_anggota'])) {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $nim_lama = trim($_POST['nim_lama'] ?? '');
    $nim      = trim($_POST['nim'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $jabatan  = trim($_POST['jabatan'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE tbl_anggota SET nim=?, nama=?, email=?, no_hp=?, jabatan=? WHERE nim=?");
    mysqli_stmt_bind_param($stmt, "ssssss", $nim, $nama, $email, $no_hp, $jabatan, $nim_lama);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['pesan'] = 'Data anggota berhasil diupdate!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: anggota.php");
    exit;
}

// HAPUS
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {
    if(!isset($_SESSION['login'])){ header('Location: login.php'); exit; }
    $nim = trim($_GET['nim'] ?? '');
    $stmt = mysqli_prepare($conn, "DELETE FROM tbl_anggota WHERE nim=?");
    mysqli_stmt_bind_param($stmt, "s", $nim);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['pesan'] = 'Data anggota berhasil dihapus!';
    $_SESSION['tipe']  = 'sukses';
    header("Location: anggota.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
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

        .container-custom {
            max-width: 1200px;
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .logo { font-size: 28px; font-weight: 700; color: #ffffff; letter-spacing: 1px; }
        .nav-links { display: flex; gap: 35px; }
        .nav-links a { text-decoration: none; color: rgba(255,255,255,0.75); font-size: 15px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #ffffff; }
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
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.6);
            text-align: left;
        }
        .table-card thead th.text-center { text-align: center; }
        .table-card tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.06);
            transition: background 0.15s;
        }
        .table-card tbody tr:hover { background: rgba(255,255,255,0.06); }
        .table-card tbody tr:last-child { border-bottom: none; }
        .table-card tbody td {
            padding: 16px 24px;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
        }
        .td-nim { color: #818cf8 !important; font-family: monospace; font-weight: 600; }
        .td-nama { color: #ffffff !important; font-weight: 500; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 50; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; border-radius: 20px; width: 100%; max-width: 500px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); overflow: hidden; }
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
            <a href="dopem.php">Dospem</a>
            <a href="matkul.php">Mata Kuliah</a>
            <a href="nilai.php">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>
        <a href="index.php" class="btn-book">Kembali ke Dashboard</a>
    </div>

    <!-- NOTIFIKASI -->
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium
            <?= $_SESSION['tipe'] === 'sukses' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?>">
            <?= htmlspecialchars($_SESSION['pesan']); ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Data Anggota</h1>
            <p class="text-sm text-slate-300 mt-1">Daftar data anggota yang terdaftar.</p>
        </div>
        <button onclick="bukaModal('modalTambah')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
            + Tambah Anggota
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Jabatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tbl_anggota");
                while ($data = mysqli_fetch_assoc($query)) :
                    $jabatanClass = strtolower($data['jabatan']) === 'ketua'
                        ? 'bg-indigo-600 text-white'
                        : 'bg-indigo-100 text-indigo-700';
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="td-nim"><?= htmlspecialchars($data['nim']); ?></td>
                    <td class="td-nama"><?= htmlspecialchars($data['nama']); ?></td>
                    <td><?= htmlspecialchars($data['email']); ?></td>
                    <td><?= htmlspecialchars($data['no_hp']); ?></td>
                    <td>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full <?= $jabatanClass ?>">
                            <?= htmlspecialchars($data['jabatan']); ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <div class="flex gap-2 justify-center">
                            <button
                                onclick="bukaModalEdit('<?= htmlspecialchars($data['nim'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['nama'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['email'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['no_hp'], ENT_QUOTES) ?>', '<?= htmlspecialchars($data['jabatan'], ENT_QUOTES) ?>')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Edit
                            </button>
                            <a href="anggota.php?aksi=hapus&nim=<?= urlencode($data['nim']) ?>"
                                onclick="return confirm('Yakin ingin hapus anggota ini?')"
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
            <h3 class="font-bold text-slate-800">Tambah Anggota</h3>
            <button onclick="tutupModal('modalTambah')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">NIM</label>
                <input type="text" name="nim" required placeholder="Contoh: I.2510001"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama</label>
                <input type="text" name="nama" required placeholder="Nama lengkap"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                <input type="email" name="email" placeholder="email@gmail.com"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">No HP</label>
                <input type="text" name="no_hp" placeholder="08xxxxxxxxxx"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jabatan</label>
                <select name="jabatan" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="Ketua">Ketua</option>
                    <option value="Anggota">Anggota</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="tutupModal('modalTambah')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" name="tambah_anggota"
                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Edit Anggota</h3>
            <button onclick="tutupModal('modalEdit')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="nim_lama" id="editNimLama">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">NIM</label>
                <input type="text" name="nim" id="editNim" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama</label>
                <input type="text" name="nama" id="editNama" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                <input type="email" name="email" id="editEmail"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">No HP</label>
                <input type="text" name="no_hp" id="editNoHp"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jabatan</label>
                <select name="jabatan" id="editJabatan" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                    <option value="Ketua">Ketua</option>
                    <option value="Anggota">Anggota</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="tutupModal('modalEdit')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" name="edit_anggota"
                    class="px-5 py-2 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold transition">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function bukaModalEdit(nim, nama, email, no_hp, jabatan) {
        document.getElementById('editNimLama').value = nim;
        document.getElementById('editNim').value     = nim;
        document.getElementById('editNama').value    = nama;
        document.getElementById('editEmail').value   = email;
        document.getElementById('editNoHp').value    = no_hp;
        document.getElementById('editJabatan').value = jabatan;
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