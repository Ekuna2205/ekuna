<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (!isset($_GET['id'])) {
    die("Project ID missing");
}

$id = intval($_GET['id']);
$msg = "";

// OLD DATA авах
$stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die("Project not found");
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $tech = trim($_POST["tech"]);

    $imagePath = $project["image"]; // default хуучин зураг

    // Хэрвээ шинэ зураг upload хийсэн бол
    if (!empty($_FILES["image"]["name"])) {

        $file = $_FILES["image"];
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowed = ["jpg","jpeg","png","gif","webp"];

        if (in_array($ext, $allowed)) {

            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            $newName = time() . "_" . uniqid() . "." . $ext;
            $path = "uploads/" . $newName;

            if (move_uploaded_file($file["tmp_name"], $path)) {
                $imagePath = $path;
            } else {
                $msg = "❌ Image upload failed";
            }

        } else {
            $msg = "⚠ Wrong file type";
        }
    }

    // UPDATE DB
    if (empty($msg)) {
        $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=?, tech=? WHERE id=?");
        $stmt->bind_param("ssssi", $title, $description, $imagePath, $tech, $id);

        if ($stmt->execute()) {
            header("Location: projects.php");
            exit;
        } else {
            $msg = "❌ Update failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Project</title>

<style>
body{
    background:#0f172a;
    color:white;
    font-family:sans-serif;
    padding:30px;
}

.box{
    max-width:700px;
    margin:auto;
    background:#111827;
    padding:30px;
    border-radius:15px;
}

h2{text-align:center;}

input, textarea{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:8px;
}

textarea{height:120px;}

button{
    width:100%;
    padding:12px;
    background:#38bdf8;
    border:none;
}

img{
    width:150px;
    border-radius:10px;
    margin:10px 0;
}

.msg{
    text-align:center;
    margin-bottom:10px;
    color:lightgreen;
}

.top{
    text-align:center;
    margin-bottom:20px;
}
.top a{
    color:#38bdf8;
    margin:0 10px;
}
</style>
</head>

<body>

<div class="box">

<div class="top">
<a href="projects.php">Back</a>
</div>

<h2>Edit Project</h2>

<?php if($msg!=""){ ?>
<p class="msg"><?= $msg ?></p>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>

<textarea name="description" required><?= htmlspecialchars($project['description']) ?></textarea>

<p>Current Image:</p>
<img src="<?= $project['image'] ?>">

<input type="file" name="image">

<input type="text" name="tech" value="<?= htmlspecialchars($project['tech']) ?>">

<button type="submit">Update</button>

</form>

</div>

</body>
</html>