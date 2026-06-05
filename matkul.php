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

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #efefef;
            padding: 40px;
        }

        .container-custom {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 25px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo {
            font-size: 28px;
            font-weight: 600;
            color: #111827;
        }

        .nav-links {
            display: flex;
            gap: 35px;
        }

        .nav-links a {
            text-decoration: none;
            color: #374151;
            font-size: 15px;
            transition: 0.3s;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #2563eb;
        }

        .btn-book {
            background: #0f172a;
            color: white;
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-book:hover {
            background: #1e293b;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.4);
            backdrop-filter: blur(4px);
            z-index: 50;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
        }
    </style>
</head>

<body>

<div class="container-custom">

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="logo">BASIS DATA 01</div>

        <div class="nav-links">
            <a href="index.php">Beranda</a>
            <a href="mahasiswa.php">Mahasiswa</a>
            <a href="dosen.php">Dosen</a>
            <a href="matkul.php" class="active">Mata Kuliah</a>
            <a href="nilai.php">Nilai</a>
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
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Mata Kuliah</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar manajemen mata kuliah semester ini.</p>
        </div>

        <button onclick="bukaModal('modalTambah')"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition duration-200">
            + Tambah Matkul
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-200">
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">Kode MK</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">Nama MK</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">SKS</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-slate-600">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM tbl_matakuliah");
                while ($matkul = mysqli_fetch_assoc($query)) :
                ?>
                <tr class="hover:bg-slate-50 transition duration-150">
                    <td class="py-4 px-6 font-mono text-sm text-indigo-600 font-semibold"><?= htmlspecialchars($matkul['kodemk']); ?></td>
                    <td class="py-4 px-6 font-medium text-slate-900"><?= htmlspecialchars($matkul['namamk']); ?></td>
                    <td class="py-4 px-6 text-center"><?= htmlspecialchars($matkul['sks']); ?></td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex gap-2 justify-center">
                            <button
                                onclick="bukaModalEdit('<?= htmlspecialchars($matkul['kodemk'], ENT_QUOTES) ?>', '<?= htmlspecialchars($matkul['namamk'], ENT_QUOTES) ?>', '<?= htmlspecialchars($matkul['sks'], ENT_QUOTES) ?>')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Edit
                            </button>
                            <a href="matkul.php?aksi=hapus&kodemk=<?= urlencode($matkul['kodemk']) ?>"
                                onclick="return confirm('Yakin ingin hapus mata kuliah ini?')"
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

<!-- ===== MODAL TAMBAH ===== -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Tambah Mata Kuliah Baru</h3>
            <button onclick="tutupModal('modalTambah')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>

        <form action="" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode Matkul</label>
                <input type="text" name="kodemk" placeholder="Contoh: INF-103" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Mata Kuliah</label>
                <input type="text" name="namamk" placeholder="Contoh: Pemrograman Web" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">SKS</label>
                <input type="number" name="sks" placeholder="Contoh: 3" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" onclick="tutupModal('modalTambah')"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" name="tambah_matkul"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Edit Mata Kuliah</h3>
            <button onclick="tutupModal('modalEdit')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>

        <form action="" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="kodemk_lama" id="editKodeLama">

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode Matkul</label>
                <input type="text" name="kodemk" id="editKode" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Mata Kuliah</label>
                <input type="text" name="namamk" id="editNama" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">SKS</label>
                <input type="number" name="sks" id="editSks" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" onclick="tutupModal('modalEdit')"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" name="edit_matkul"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    Update
                </button>
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

    // Klik di luar modal = tutup
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });
</script>

</body>
</html>