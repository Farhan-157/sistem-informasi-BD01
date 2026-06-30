<?php

$conn = mysqli_connect(
    getenv('DB_HOST') ?: "localhost",
    getenv('DB_USER') ?: "root",
    getenv('DB_PASS') ?: "",
    getenv('DB_NAME') ?: "basisdata2026"
);

if(!$conn){
    die("Koneksi database gagal");
}
?>
