<?php

function set_flash($pesan, $tipe = 'sukses') {
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe']  = $tipe;
}

?>
