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
            background: rgba(0,0,0,0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
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
            <a href="dosen.php" class="active">Dosen</a>
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
            <?= $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Data Dosen</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar data dosen yang terdaftar.</p>
        </div>
        <button onclick="bukaModalTambah()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
            + Tambah Dosen
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-200">
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">No</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">NID</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">Nama Dosen</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-slate-600">
                <?php
                $no = 1;
                $data = mysqli_query($conn, "SELECT * FROM tbl_dosen");
                while($row = mysqli_fetch_array($data)) :
                ?>
                <tr class="hover:bg-slate-50 transition duration-150">
                    <td class="py-4 px-6"><?= $no++; ?></td>
                    <td class="py-4 px-6 font-mono text-sm text-indigo-600 font-semibold"><?= htmlspecialchars($row['nid']); ?></td>
                    <td class="py-4 px-6 font-medium text-slate-900"><?= htmlspecialchars($row['namados']); ?></td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex gap-2 justify-center">
                            <!-- Tombol Edit -->
                            <button
                                onclick="bukaModalEdit('<?= htmlspecialchars($row['nid'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['namados'], ENT_QUOTES) ?>')"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Edit
                            </button>
                            <!-- Tombol Hapus -->
                            <a href="dosen_action.php?aksi=hapus&nid=<?= urlencode($row['nid']) ?>"
                                onclick="return confirm('Yakin ingin hapus dosen ini?')"
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
        <h2 class="text-xl font-bold text-slate-800 mb-5">Tambah Dosen</h2>
        <form action="dosen_action.php" method="POST">
            <input type="hidden" name="aksi" value="tambah">

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">NID</label>
                <input type="text" name="nid" required
                    class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: D001">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Dosen</label>
                <input type="text" name="namados" required
                    class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama lengkap dosen">
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" onclick="tutupModal('modalTambah')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <h2 class="text-xl font-bold text-slate-800 mb-5">Edit Dosen</h2>
        <form action="dosen_action.php" method="POST">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="nid_lama" id="editNidLama">

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">NID</label>
                <input type="text" name="nid" id="editNid" required
                    class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Dosen</label>
                <input type="text" name="namados" id="editNama" required
                    class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" onclick="tutupModal('modalEdit')"
                    class="px-5 py-2 rounded-lg border border-slate-300 text-sm text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-semibold transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() {
        document.getElementById('modalTambah').classList.add('active');
    }

    function bukaModalEdit(nid, nama) {
        document.getElementById('editNidLama').value = nid;
        document.getElementById('editNid').value = nid;
        document.getElementById('editNama').value = nama;
        document.getElementById('modalEdit').classList.add('active');
    }

    function tutupModal(idModal) {
        document.getElementById(idModal).classList.remove('active');
    }

    // Klik di luar modal = tutup
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>