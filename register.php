<?php
include 'config.php';

$error = "";

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM tbl_users WHERE username = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){

        $error = "Username sudah digunakan!";

    }else{

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = mysqli_prepare(
            $conn,
            "INSERT INTO tbl_users(username,password) VALUES(?, ?)"
        );
        mysqli_stmt_bind_param($stmt2, "ss", $username, $hashed);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        echo "
        <script>
        alert('Registrasi berhasil');
        window.location='login.php';
        </script>
        ";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#0f172a,#1e293b,#334155);
}

.register-container{
width:420px;
padding:45px;
background:rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.2);
backdrop-filter:blur(20px);
border-radius:25px;
box-shadow:0 8px 32px rgba(0,0,0,0.4);
}

.register-container h1{
text-align:center;
color:white;
margin-bottom:10px;
}

.subtitle{
text-align:center;
color:#cbd5e1;
margin-bottom:25px;
}

.input-box{
margin-bottom:20px;
}

.input-box label{
display:block;
color:white;
margin-bottom:8px;
}

.input-box input{
width:100%;
padding:15px;
border:none;
border-radius:12px;
background:rgba(255,255,255,0.12);
color:white;
}

.register-btn{
width:100%;
padding:15px;
border:none;
border-radius:12px;
background:#2563eb;
color:white;
cursor:pointer;
}

.error{
background:red;
color:white;
padding:10px;
border-radius:10px;
margin-bottom:15px;
text-align:center;
}

.extra{
margin-top:20px;
text-align:center;
}

.extra a{
color:#cbd5e1;
text-decoration:none;
}

</style>
</head>
<body>

<div class="register-container">

<h1>REGISTER</h1>
<p class="subtitle">Buat akun baru</p>

<?php if($error!=""){ ?>
<div class="error">
<?php echo $error; ?>
</div>
<?php } ?>

<form method="POST">

<div class="input-box">
<label>Username</label>
<input
type="text"
name="username"
required>
</div>

<div class="input-box">
<label>Password</label>
<input
type="password"
name="password"
required>
</div>

<button
type="submit"
name="register"
class="register-btn">

Daftar

</button>

</form>

<div class="extra">
<a href="login.php">
Sudah punya akun? Login
</a>
</div>

</div>

</body>
</html>