<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "basisdata2026"
);

if (!$conn) {
    die("Koneksi gagal : " . mysqli_connect_error());
}

?>
