<?php
include 'config.php';

$username = $_GET['username'];

if(isset($_POST['simpan'])){

    $password = $_POST['password'];

    mysqli_query(
        $conn,
        "UPDATE tbl_users
         SET password='$password'
         WHERE username='$username'"
    );

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