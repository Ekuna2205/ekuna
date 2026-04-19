<?php
session_start();
include 'db.php';

$msg="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $password=md5($_POST["password"]);

    $sql="SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result=$conn->query($sql);

    if($result->num_rows>0){
        $_SESSION["admin"]="true";
        header("Location: index.php");
        exit;
    }else{
        $msg="❌ Invalid login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{
background:#0f172a;color:white;
display:flex;justify-content:center;align-items:center;
height:100vh;font-family:sans-serif;
}
.box{
background:#111827;padding:30px;border-radius:10px;
width:300px;text-align:center;
}
input{
width:100%;padding:10px;margin:10px 0;border:none;
}
button{
width:100%;padding:10px;background:#38bdf8;border:none;
}
</style>
</head>
<body>

<div class="box">
<h2>Admin Login</h2>

<p><?= $msg ?></p>

<form method="POST">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<button>Login</button>
</form>

</div>

</body>
</html>