<?php
session_start();
include 'config.php';

if(isset($_POST['cari'])){

    $username = $_POST['username'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM tbl_users WHERE username = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){

        $token = bin2hex(random_bytes(32));
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_username'] = $username;

        header("Location: reset_password.php?token=" . urlencode($token));
        exit();

    }else{

        echo "Username tidak ditemukan";
    }
    mysqli_stmt_close($stmt);
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
