<?php if (isset($_SESSION['pesan'])): ?>
    <div class="<?= $_SESSION['tipe'] === 'sukses' ? 'notif-sukses' : 'notif-gagal' ?>">
        <?= $_SESSION['pesan']; ?>
    </div>
    <?php unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
<?php endif; ?>
