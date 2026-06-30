<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<div class="navbar">
    <div class="logo">BASIS DATA 01</div>
    <div class="nav-links">
        <?php
        $nav_items = [
            'index'     => 'Beranda',
            'mahasiswa' => 'Mahasiswa',
            'dosen'     => 'Dosen',
            'dopem'     => 'Dospem',
            'matkul'    => 'Mata Kuliah',
            'nilai'     => 'Nilai',
            'anggota'   => 'Anggota',
        ];
        foreach ($nav_items as $page => $label):
            $active = ($current_page === $page) ? ' class="active"' : '';
        ?>
            <a href="<?= $page ?>.php"<?= $active ?>><?= $label ?></a>
        <?php endforeach; ?>
    </div>
    <?php if ($current_page === 'index'): ?>
        <?php if (!isset($_SESSION['login'])): ?>
            <a href="login.php" class="btn-book">Login &#x2197;</a>
        <?php else: ?>
            <a href="logout.php" class="btn-book">logout &#x2197;</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="index.php" class="btn-book">Kembali ke Dashboard</a>
    <?php endif; ?>
</div>
