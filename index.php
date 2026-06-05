<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Website BD01 kelompok 7</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">

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

            <?php if(isset($_SESSION['login'])){ ?>

             <a href="logout.php" class="btn-book">
             Logout ↗
             </a>

             <?php } else { ?>

            <a href="login.php" class="btn-book">
             Login ↗
            </a>

             <?php } ?>
        </div>

        <!-- HERO -->
        <div class="hero">

            <div class="overlay"></div>

            <div class="hero-content">
                <h1>
                    Sistem Informasi Akademik
                </h1>

                <p>
                    Selamat datang di website sistem informasi akademik, kalian dapat melihat beberapa data yang telah kami buat
                    yaitu data mahasiswa, data dosen, data mata kuliah, nilai dan juga data anggota kami sendiri.
                </p>

                <a href="index.php" class="btn-start">
                    Mulai Sekarang
                </a>
            </div>

            <!-- BOTTOM -->
            <div class="bottom-info">

                <div class="players">
                    <span>Our Team : </span>
                    <br />
                    <img src="img/windut.jpg">
                    <img src="img/windut.jpg">
                    <img src="img/windut.jpg">
                    <img src="img/windut.jpg">
                    <img src="img/windut.jpg">
                    <img src="img/gwe.jpeg">
                </div>

                <div class="socials">
                    <a href="https://www.instagram.com/f.hans15?igsh=YWJ5dWM0MGFwYzF0" target="_blank">Instagram ↗</a>
                    <a href="https://github.com/Farhan-157/sistem-informasi-BD01" target="_blank">GitHub ↗</a>
                </div>

            </div>

        </div>

    </div>

</body>
</html>