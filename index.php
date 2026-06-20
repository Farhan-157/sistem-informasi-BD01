<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Website BD01 kelompok 7</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: url('img/hero.jpg') center/cover fixed;
            min-height: 100vh;
            padding: 40px;
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
            position: relative;
            z-index: 1;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .logo { font-size: 28px; font-weight: 700; color: white; }
        .nav-links { display: flex; gap: 35px; }
        .nav-links a { text-decoration: none; color: white; font-size: 15px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #2563eb; }
        .btn-book {
            background: #0f172a; color: white; padding: 12px 28px;
            border-radius: 30px; text-decoration: none; font-size: 14px;
        }
        .btn-book:hover { background: #1e293b; }

        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 120px 20px 60px;
        }
        .hero-content h1 {
            font-size: 64px;
            line-height: 1.2;
            font-weight: 600;
            max-width: 850px;
            margin-bottom: 20px;
        }
        .hero-content p {
            font-size: 18px;
            max-width: 650px;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #f3f4f6;
        }
        .btn-start {
            background: #111827; color: white; text-decoration: none;
            padding: 16px 35px; border-radius: 40px; transition: 0.3s;
        }
        .btn-start:hover { background: #1f2937; transform: translateY(-3px); }

        .bottom-info {
            position: fixed;
            bottom: 25px; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            z-index: 2;
            padding: 0 calc((100% - 1200px) / 2 + 25px);
        }
        .players { display: flex; align-items: center; gap: 10px; }
        .players img {
            width: 40px; height: 40px; border-radius: 50%;
            border: 2px solid white; object-fit: cover; margin-left: -10px;
        }
        .socials { display: flex; gap: 20px; }
        .socials a { color: white; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
<div class="container-custom">

    <div class="navbar">
        <div class="logo">BASIS DATA 01</div>
        <div class="nav-links">
            <a href="index.php" class="active">Beranda</a>
            <a href="mahasiswa.php">Mahasiswa</a>
            <a href="dosen.php">Dosen</a>
            <a href="dopem.php">Dospem</a>
            <a href="matkul.php">Mata Kuliah</a>
            <a href="nilai.php">Nilai</a>
            <a href="anggota.php">Anggota</a>
        </div>
        <?php if(!isset($_SESSION['login'])){ ?>
        <a href="login.php" class="btn-book">Login ↗</a>
        <?php } else { ?>
        <a href="logout.php" class="btn-book">logout ↗</a>
        <?php } ?>
    </div>

    <!-- KONTEN -->
    <div class="hero-content">
        <h1>Sistem Informasi Akademik</h1>
        <p>Selamat datang di website sistem informasi akademik, kalian dapat melihat beberapa data yang telah kami buat
            yaitu data mahasiswa, data dosen, data mata kuliah, nilai dan juga data anggota kami sendiri.</p>
        <a href="mahasiswa.php" class="btn-start">Mulai Sekarang</a>
    </div>

</div>

<!-- BOTTOM INFO -->
<div class="bottom-info">
    <div class="players">
        <span>Our Team : </span>
        <img src="img/aufa.jpeg">
        <img src="img/dafa.jpeg">
        <img src="img/nabil.jpeg">
        <img src="img/syihan.jpeg">
        <img src="img/alza.jpeg">
        <img src="img/farhan.jpeg">
    </div>
    <div class="socials">
        <a href="https://www.instagram.com/f.hans15?igsh=YWJ5dWM0MGFwYzF0" target="_blank">Instagram ↗</a>
        <a href="https://github.com/Farhan-157/sistem-informasi-BD01" target="_blank">GitHub ↗</a>
    </div>
</div>

</body>
</html>