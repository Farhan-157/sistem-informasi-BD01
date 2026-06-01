<?php

session_start();
include 'includes/koneksi.php';

// Tambah data matkul
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_matkul'])) {

    $kode = $_POST['kodemk'];
    $nama = $_POST['namamk'];
    $sks = $_POST['sks'];

    $sql = "INSERT INTO tbl_matakuliah (kodemk, namamk, sks)
    VALUES ('$kode', '$nama', '$sks')";

    mysqli_query($conn, $sql);

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

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            background:#efefef;
            padding:40px;
        }

        .container-custom{
            max-width:1200px;
            margin:auto;
            background:white;
            padding:25px;
            border-radius:25px;
        }

        /* NAVBAR */

        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            padding-bottom:20px;
            border-bottom:1px solid #e5e7eb;
        }

        .logo{
            font-size:28px;
            font-weight:600;
            color:#111827;
        }

        .nav-links{
            display:flex;
            gap:35px;
        }

        .nav-links a{
            text-decoration:none;
            color:#374151;
            font-size:15px;
            transition:0.3s;
        }

        .nav-links a:hover{
            color:#2563eb;
        }

        .btn-book{
            background:#0f172a;
            color:white;
            padding:12px 28px;
            border-radius:30px;
            text-decoration:none;
            font-size:14px;
            transition:0.3s;
        }

        .btn-book:hover{
            background:#1e293b;
        }

        /* BUTTON KEMBALI */

        .back-btn{
            display:inline-block;
            margin-bottom:25px;
            padding:12px 24px;
            background:#0f172a;
            color:white;
            text-decoration:none;
            border-radius:12px;
            transition:0.3s;
            font-size:14px;
        }

        .back-btn:hover{
            background:#1e293b;
            transform:translateY(-2px);
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
            <a href="matkul.php">Mata Kuliah</a>
            <a href="nilai.php">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>

        <a href="index.php" class="btn-book">
            Kembali ke Dashboard
        </a>

    </div>

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                Mata Kuliah
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Daftar manajemen mata kuliah semester ini.
            </p>
        </div>

        <button onclick="bukaModal()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition duration-200">

            + Tambah Matkul

        </button>

    </div>
        <br />
    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-slate-100 border-b border-slate-200">

                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">
                        kodemk
                    </th>

                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">
                        namamk
                    </th>

                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">
                        sks
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 text-slate-600">

                <?php

                 $query = mysqli_query($conn, "SELECT * FROM tbl_matakuliah");

                 while($matkul = mysqli_fetch_assoc($query)) :

                ?>

                    <tr class="hover:bg-slate-50 transition duration-150">

                        <td class="py-4 px-6 font-mono text-sm text-indigo-600 font-semibold">
                         <?= $matkul['kodemk']; ?>
                        </td>

                        <td class="py-4 px-6 font-medium text-slate-900">
                         <?= $matkul['namamk']; ?>
                        </td>

                        <td class="py-4 px-6 text-center">
                         <?= $matkul['sks']; ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL -->
<div id="modalForm"
    class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden">

        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">

            <h3 class="font-bold text-slate-800">
                Tambah Mata Kuliah Baru
            </h3>

            <button onclick="tutupModal()"
                class="text-slate-400 hover:text-slate-600 font-bold">

                &times;

            </button>

        </div>

        <form action="" method="POST" class="p-6 space-y-4">

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Kode Matkul
                </label>

                <input type="text" name="kodemk"
                    placeholder="Contoh: INF-103"
                    required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Nama Mata Kuliah
                </label>

                <input type="text" name="namamk"
                    placeholder="Contoh: Pemrograman Web"
                    required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    SKS
                </label>

                <input type="number" name="sks"
                    placeholder="Contoh: 3"
                    required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div class="flex justify-end space-x-3 pt-2">

                <button type="button"
                    onclick="tutupModal()"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition">

                    Batal

                </button>

                <button type="submit"
                    name="tambah_matkul"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

    function bukaModal(){
        document.getElementById('modalForm').classList.remove('hidden');
    }

    function tutupModal(){
        document.getElementById('modalForm').classList.add('hidden');
    }

</script>

</body>
</html>