<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// COUNTS
$projectCount = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];
$messageCount = $conn->query("SELECT COUNT(*) as total FROM contacts")->fetch_assoc()['total'];

// LATEST PROJECT
$latest = $conn->query("SELECT * FROM projects ORDER BY id DESC LIMIT 1");
$latestProject = $latest->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
body{
    background:#0f172a;
    color:white;
    font-family:sans-serif;
    margin:0;
    padding:20px;
}

.header{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
}

.header a{
    color:#38bdf8;
    text-decoration:none;
    margin-left:15px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.card{
    background:#111827;
    padding:25px;
    border-radius:15px;
    text-align:center;
}

.card h2{
    font-size:35px;
    color:#38bdf8;
}

.latest{
    margin-top:30px;
    background:#111827;
    padding:20px;
    border-radius:15px;
}

.latest img{
    width:200px;
    border-radius:10px;
}

.buttons{
    margin-top:20px;
    display:flex;
    gap:15px;
}

.btn{
    padding:10px 15px;
    background:#38bdf8;
    color:black;
    text-decoration:none;
    border-radius:8px;
}
</style>

</head>
<body>

<div class="header">
<h1>Admin Dashboard</h1>
<div>
<a href="index.php">Home</a>
<a href="logout.php">Logout</a>
</div>
</div>

<div class="grid">

<div class="card">
<h2><?= $projectCount ?></h2>
<p>Total Projects</p>
</div>

<div class="card">
<h2><?= $messageCount ?></h2>
<p>Total Messages</p>
</div>

<div class="card">
<h2>Admin</h2>
<p>Logged in</p>
</div>

</div>

<div class="latest">
<h2>Latest Project</h2>

<?php if($latestProject){ ?>
<h3><?= $latestProject['title'] ?></h3>
<p><?= $latestProject['description'] ?></p>
<img src="<?= $latestProject['image'] ?>">
<?php } else { ?>
<p>No projects yet</p>
<?php } ?>

<div class="buttons">
<a class="btn" href="add_project.php">Add Project</a>
<a class="btn" href="projects.php">Manage Projects</a>
<a class="btn" href="messages.php">View Messages</a>
</div>

</div>

</body>
</html>