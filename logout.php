<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#0f172a;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    text-align:center;
    background:#1e293b;
    padding:50px;
    border-radius:20px;
    width:420px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

h1{
    margin-bottom:10px;
}

h2{
    color:#38bdf8;
    margin-bottom:30px;
}

/* BUTTON */

.logout-btn{
    padding:14px 30px;
    border:none;
    border-radius:12px;
    background:#ef4444;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.logout-btn:hover{
    background:#dc2626;
    transform:translateY(-3px);
}

/* POPUP */

.popup{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    display:none;
    justify-content:center;
    align-items:center;
}

.popup-box{
    background:white;
    color:#111827;
    padding:35px;
    border-radius:20px;
    width:350px;
    text-align:center;
    animation:popup 0.3s ease;
}

@keyframes popup{
    from{
        transform:scale(0.7);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.popup-box h3{
    margin-bottom:15px;
    font-size:24px;
}

.popup-box p{
    margin-bottom:25px;
    color:#6b7280;
}

/* BUTTON GROUP */

.btn-group{
    display:flex;
    justify-content:center;
    gap:15px;
}

.cancel-btn{
    padding:12px 25px;
    border:none;
    border-radius:10px;
    background:#9ca3af;
    color:white;
    cursor:pointer;
    font-weight:bold;
}

.cancel-btn:hover{
    background:#6b7280;
}

.confirm-btn{
    padding:12px 25px;
    border:none;
    border-radius:10px;
    background:#ef4444;
    color:white;
    cursor:pointer;
    font-weight:bold;
    text-decoration:none;
}

.confirm-btn:hover{
    background:#dc2626;
}

</style>
</head>
<body>

<div class="box">

    <h1>Selamat Datang</h1>

    <h2>
        <?php echo $_SESSION['username']; ?>
    </h2>

    <button class="logout-btn" onclick="openPopup()">
        Logout
    </button>

</div>

<!-- POPUP -->

<div class="popup" id="popup">

    <div class="popup-box">

        <h3>Konfirmasi Logout</h3>

        <p>Apakah Anda yakin ingin keluar?</p>

        <div class="btn-group">

            <button class="cancel-btn" onclick="closePopup()">
                Batal
            </button>

            <a href="login.php" class="confirm-btn">
                Ya, Logout
            </a>

        </div>

    </div>

</div>

<script>

function openPopup(){
    document.getElementById("popup").style.display = "flex";
}

function closePopup(){
    document.getElementById("popup").style.display = "none";
}

</script>

</body>
</html>