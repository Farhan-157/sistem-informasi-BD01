<?php include 'includes/koneksi.php'; ?>
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

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Data Dosen</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar data dosen yang terdaftar.</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-200">
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">No</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">NID</th>
                    <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">Nama Dosen</th>
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
                    <td class="py-4 px-6 font-mono text-sm text-indigo-600 font-semibold"><?= $row['nid']; ?></td>
                    <td class="py-4 px-6 font-medium text-slate-900"><?= $row['namados']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>