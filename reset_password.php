<?php
include 'config.php';

if(!isset($_GET['username']) || $_GET['username'] === ''){
    echo "<p>Parameter username tidak valid.</p>";
    exit();
}

$username = $_GET['username'];

if(isset($_POST['simpan'])){

    $password = $_POST['password'];

    $result = mysqli_query(
        $conn,
        "UPDATE tbl_users
         SET password='$password'
         WHERE username='$username'"
    );

    if($result && mysqli_affected_rows($conn) > 0){
        echo "
        <script>
        alert('Password berhasil diubah');
        window.location='login.php';
        </script>
        ";
    } elseif($result) {
        echo "<p>Username tidak ditemukan atau password tidak berubah.</p>";
    } else {
        echo "<p>Gagal mengubah password: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
    }
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