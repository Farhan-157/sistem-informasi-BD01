<?php
include 'config.php';

if(isset($_POST['cari'])){

    $username = $_POST['username'];

    $cek = mysqli_query(
        $conn,
        "SELECT * FROM tbl_users
         WHERE username='$username'"
    );

    if(mysqli_num_rows($cek) > 0){

        header(
        "Location: reset_password.php?username=".$username
        );

        exit();

    }else{

        echo "Username tidak ditemukan";
    }
}
?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Masukkan Username"
required>

<button name="cari">
Cari Akun
</button>

</form>