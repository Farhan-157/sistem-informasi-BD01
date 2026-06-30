<?php
session_start();
include 'config.php';

$token = $_GET['token'] ?? '';

if(empty($token) || !isset($_SESSION['reset_token']) || !hash_equals($_SESSION['reset_token'], $token)){
    die("Link reset tidak valid atau sudah kedaluwarsa.");
}

$username = $_SESSION['reset_username'];

if(isset($_POST['simpan'])){

    $password = $_POST['password'];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE tbl_users SET password = ? WHERE username = ?"
    );
    mysqli_stmt_bind_param($stmt, "ss", $hashed, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    unset($_SESSION['reset_token']);
    unset($_SESSION['reset_username']);

    echo "
    <script>
    alert('Password berhasil diubah');
    window.location='login.php';
    </script>
    ";
}
?>

<form method="POST">

<input
type="password"
name="password"
placeholder="Password Baru"
required>

<button name="simpan">
Simpan Password
</button>

</form>
