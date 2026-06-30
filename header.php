<?php

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<style>
  :root {
    --color-brand:       #a78bfa;
    --color-brand-dark:  #9061f9;
    --color-text:        #1a1a1a;
    --color-text-muted:  #555;
    --color-bg:          #ffffff;
    --color-border:      rgba(0,0,0,0.1);
    --color-topbar-bg:   #0f0f0f;
    --color-topbar-text: #d4d4d4;
    --font-display:      'Playfair Display', Georgia, serif;
    --font-body:         'DM Sans', system-ui, sans-serif;
    --header-height:     72px;
    --transition:        0.22s cubic-bezier(0.4, 0, 0.2, 1);
  }

  a { text-decoration: none; color: inherit; }

  .topbar {
    background: var(--color-topbar-bg);
    color: var(--color-topbar-text);
    font-size: 13px;
    text-align: center;
    padding: 9px 16px;
    letter-spacing: 0.03em;
  }
  .topbar a {
    color: var(--color-brand);
    font-weight: 500;
    margin-left: 6px;
    transition: opacity var(--transition);
  }
  .topbar a:hover { opacity: 0.8; }

  .site-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 0.5px solid var(--color-border);
    transition: box-shadow var(--transition);
    font-family: var(--font-body);
  }
  .site-header.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.08); }

  .header-inner {
    display: flex;
    align-items: center;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
    height: var(--header-height);
  }

  .logo {
    font-family: var(--font-display);
    font-size: 26px;
    color: var(--color-text);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }
  .logo-dot {
    width: 9px; height: 9px;
    background: var(--color-brand);
    border-radius: 50%;
    animation: pulse 2.4s ease-in-out infinite;
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.75); }
  }

  .nav-desktop {
    display: flex;
    align-items: center;
    gap: 28px;
    flex: 1;
  }
  .nav-link {
    position: relative;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-text-muted);
    transition: color var(--transition);
    white-space: nowrap;
  }
  .nav-link::after {
    content: '';
    position: absolute;
    bottom: -4px; left: 0;
    width: 0; height: 2px;
    background: var(--color-brand);
    border-radius: 2px;
    transition: width var(--transition);
  }
  .nav-link:hover, .nav-link.active { color: var(--color-text); }
  .nav-link:hover::after, .nav-link.active::after { width: 100%; }

  .nav-link.has-dropdown { display: flex; align-items: center; gap: 4px; }
  .chevron { font-size: 18px; line-height: 1; transition: transform var(--transition); }
  .has-dropdown:hover .chevron { transform: rotate(180deg); }

  .dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 14px); left: -16px;
    background: #fff;
    border: 0.5px solid var(--color-border);
    border-radius: 12px;
    padding: 8px;
    min-width: 200px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.10);
  }
  .has-dropdown:hover .dropdown { display: flex; flex-direction: column; }
  .dropdown a {
    font-size: 14px;
    color: var(--color-text-muted);
    padding: 10px 14px;
    border-radius: 8px;
    transition: background var(--transition), color var(--transition);
  }
  .dropdown a:hover { background: #f4f0ff; color: var(--color-brand-dark); }

  .header-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

  .btn-search {
    display: flex; align-items: center; gap: 7px;
    background: none;
    border: 0.5px solid var(--color-border);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    font-family: var(--font-body);
    font-weight: 500;
    color: var(--color-text-muted);
    cursor: pointer;
    transition: border-color var(--transition), color var(--transition);
  }
  .btn-search:hover { border-color: #aaa; color: var(--color-text); }

  .btn-outline {
    font-size: 14px; font-weight: 500;
    color: var(--color-text);
    border: 0.5px solid var(--color-border);
    border-radius: 8px;
    padding: 9px 18px;
    transition: background var(--transition), border-color var(--transition);
  }
  .btn-outline:hover { background: #f5f5f5; border-color: #ccc; }

  .btn-primary {
    display: inline-block;
    background: var(--color-brand);
    color: #fff !important;
    font-size: 14px; font-weight: 500;
    font-family: var(--font-body);
    border: none; border-radius: 8px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
  }
  .btn-primary:hover { background: var(--color-brand-dark); transform: translateY(-1px); }
  .btn-primary:active { transform: scale(0.97); }

  .hamburger {
    display: none;
    flex-direction: column; gap: 5px;
    cursor: pointer; background: none; border: none;
    padding: 6px; margin-left: auto;
  }
  .hamburger span {
    display: block; width: 22px; height: 2px;
    background: var(--color-text); border-radius: 2px;
    transition: transform 0.3s, opacity 0.3s;
  }
  .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
  .hamburger.open span:nth-child(2) { opacity: 0; }
  .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

  .mobile-menu {
    display: none; flex-direction: column;
    background: #fff;
    border-bottom: 0.5px solid var(--color-border);
    padding: 16px 28px 24px; gap: 4px;
    font-family: var(--font-body);
  }
  .mobile-menu a {
    font-size: 16px; font-weight: 500;
    color: var(--color-text-muted);
    padding: 12px 0;
    border-bottom: 0.5px solid #f0f0f0;
    transition: color var(--transition);
  }
  .mobile-menu a:hover { color: var(--color-text); }
  .mobile-actions { display: flex; gap: 10px; margin-top: 16px; }
  .mobile-actions .btn-outline,
  .mobile-actions .btn-primary { flex: 1; text-align: center; }

  @media (max-width: 900px) {
    .nav-desktop { display: none; }
    .header-actions { display: none; }
    .hamburger { display: flex; }
    .mobile-menu.open { display: flex; }
  }
  @media (max-width: 480px) {
    .header-inner { padding: 0 20px; }
  }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />

<!-- TOPBAR -->
<div class="topbar">
  Dapatkan diskon 30% untuk plan tahunan <a href="#">&rarr; Cek sekarang</a>
</div>

<!-- HEADER -->
<header class="site-header" id="siteHeader">
  <div class="header-inner">
    <a href="index.php" class="logo">
      <span class="logo-dot"></span>
      Nexara
    </a>

    <nav class="nav-desktop" aria-label="Navigasi utama">
      <?php
        $nav_items = [
          'index'      => 'Beranda',
          'mahasiswa'  => 'Mahasiswa',
          'matkul'     => 'Mata Kuliah',
          'nilai'      => 'Nilai',
        ];
        foreach ($nav_items as $page => $label):
          $is_active = ($current_page === $page) ? 'active' : '';
      ?>
        <a href="<?= $page ?>.php" class="nav-link <?= $is_active ?>"><?= $label ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="header-actions">
      <a href="logout.php" class="btn-outline">Logout</a>
      <a href="login.php" class="btn-primary">Login</a>
    </div>

    <button class="hamburger" id="hamburger" aria-label="Buka menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Beranda</a>
  <a href="mahasiswa.php">Mahasiswa</a>
  <a href="matkul.php">Mata Kuliah</a>
  <a href="nilai.php">Nilai</a>
  <div class="mobile-actions">
    <a href="logout.php" class="btn-outline">Logout</a>
    <a href="login.php" class="btn-primary">Login</a>
  </div>
</div>

<script>
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  hamburger.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.toggle('open');
    hamburger.classList.toggle('open', isOpen);
    hamburger.setAttribute('aria-expanded', isOpen);
  });
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      hamburger.classList.remove('open');
      hamburger.setAttribute('aria-expanded', false);
    });
  });
  window.addEventListener('scroll', () => {
    document.getElementById('siteHeader').classList.toggle('scrolled', window.scrollY > 10);
  });
</script>
