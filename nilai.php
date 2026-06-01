<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Mahasiswa</title>

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
            margin-bottom:35px;
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
        
        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            padding-bottom:20px;
            border-bottom:1px solid #d1d5db;
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
            <a href="matkul.php">Mata kuliah</a>
            <a href="nilai.php">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>

        <a href="index.php" class="btn-book">
            Kembali ke Dashboard
        </a>

    </div>
    
    <!-- CONTENT -->
    <div class="max-w-5xl mx-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                Nilai Mahasiswa
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Transkrip dan rekapitulasi nilai mahasiswa berdasarkan mata kuliah.
            </p>

        </button>
        </div>
        <br />
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200">

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center w-16">
                            No
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">
                            NIM
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">
                            Nama Mahasiswa
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider">
                            Mata Kuliah
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">
                            Nilai Angka
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">
                            Huruf
                        </th>

                        <th class="py-4 px-6 text-sm font-semibold text-slate-700 uppercase tracking-wider text-center">
                            Status
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 text-slate-600">

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">1</td>
                        <td class="py-4 px-6 font-mono text-sm">22010011</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Farhan</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">88</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">2</td>
                        <td class="py-4 px-6 font-mono text-sm">22010012</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Alza</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">85</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">3</td>
                        <td class="py-4 px-6 font-mono text-sm">22010013</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Nabill</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">82</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">4</td>
                        <td class="py-4 px-6 font-mono text-sm">22010014</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Aufa</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">92</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">5</td>
                        <td class="py-4 px-6 font-mono text-sm">22010015</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Dafa</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">81</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="py-4 px-6 text-center font-medium text-slate-900">6</td>
                        <td class="py-4 px-6 font-mono text-sm">22010016</td>
                        <td class="py-4 px-6 font-medium text-slate-900">Syihan</td>
                        <td class="py-4 px-6">Basis Data</td>
                        <td class="py-4 px-6 text-center font-semibold">87</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">A</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                Lulus
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>
</div>

</body>
</html>