<?php
session_start();

include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM tbl_users
        WHERE username='$username'
        AND password='$password'"
    );

    if(!$query){
        $error = "Terjadi kesalahan sistem. Silakan coba lagi.";
    } elseif(mysqli_num_rows($query) > 0){

        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        header("Location: index.php");
        exit();

    }else{

        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Modern Login Page</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    overflow:hidden;
}


.circle{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.1);
    animation:animate 15s linear infinite;
}

.circle:nth-child(1){
    width:250px;
    height:250px;
    top:-80px;
    left:-80px;
}

.circle:nth-child(2){
    width:350px;
    height:350px;
    bottom:-120px;
    right:-120px;
}

.circle:nth-child(3){
    width:150px;
    height:150px;
    top:50%;
    left:10%;
}

@keyframes animate{
    0%{
        transform:translateY(0px) rotate(0deg);
    }
    100%{
        transform:translateY(-30px) rotate(360deg);
    }
}

/* LOGIN BOX */

.login-container{
    position:relative;
    width:420px;
    padding:45px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    backdrop-filter:blur(20px);
    border-radius:25px;
    box-shadow:0 8px 32px rgba(0,0,0,0.4);
    z-index:10;
}

.login-container h1{
    text-align:center;
    color:white;
    margin-bottom:10px;
    font-size:35px;
    font-weight:700;
}

.subtitle{
    text-align:center;
    color:#cbd5e1;
    margin-bottom:35px;
    font-size:14px;
}

.input-box{
    margin-bottom:25px;
}

.input-box label{
    display:block;
    color:#fff;
    margin-bottom:8px;
    font-size:14px;
}

.input-box input{
    width:100%;
    padding:15px;
    border:none;
    outline:none;
    border-radius:12px;
    background:rgba(255,255,255,0.12);
    color:white;
    font-size:15px;
    transition:0.3s;
}

.input-box input::placeholder{
    color:#cbd5e1;
}

.input-box input:focus{
    background:rgba(255,255,255,0.18);
    transform:scale(1.02);
}

.login-btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.login-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(37,99,235,0.4);
}

.extra{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
    font-size:13px;
}

.extra a{
    color:#cbd5e1;
    text-decoration:none;
    transition:0.3s;
}

.extra a:hover{
    color:white;
}

.error{
    background:#ef4444;
    color:white;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
    font-size:14px;
}

.footer{
    margin-top:30px;
    text-align:center;
    color:#94a3b8;
    font-size:12px;
}

</style>
</head>
<body>

<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>

<div class="login-container">

    <h1>LOGIN</h1>
    <p class="subtitle">Silahkan masuk ke akun Anda</p>

    <?php if($error != ""){ ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="login-btn">
            Masuk Sekarang
        </button>

    </form>

    <div class="extra">
    <a href="forgot_password.php">Lupa Password?</a>
    <a href="register.php">Daftar</a>
</div>

    <div class="footer">
        © 2026 kelompok 7 ilmu komputer universitas djuanda
    </div>

</div>

</body>
</html>