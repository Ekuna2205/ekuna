<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $tech = trim($_POST["tech"] ?? "");

    if (!empty($title) && !empty($description) && isset($_FILES["image"])) {
        $image = $_FILES["image"];

        if ($image["error"] === 0) {
            $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];
            $fileName = $image["name"];
            $tmpName = $image["tmp_name"];
            $fileSize = $image["size"];

            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowedTypes)) {
                if ($fileSize <= 5 * 1024 * 1024) {
                    if (!is_dir("uploads")) {
                        mkdir("uploads", 0777, true);
                    }

                    $newFileName = time() . "_" . uniqid() . "." . $ext;
                    $uploadPath = "uploads/" . $newFileName;

                    if (move_uploaded_file($tmpName, $uploadPath)) {
                        $stmt = $conn->prepare("INSERT INTO projects (title, description, image, tech) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssss", $title, $description, $uploadPath, $tech);

                        if ($stmt->execute()) {
                            $msg = "✅ Project added successfully!";
                        } else {
                            $msg = "❌ Database error: " . $conn->error;
                        }

                        $stmt->close();
                    } else {
                        $msg = "❌ Image upload failed.";
                    }
                } else {
                    $msg = "⚠ Image size must be 5MB or less.";
                }
            } else {
                $msg = "⚠ Only jpg, jpeg, png, gif, webp files are allowed.";
            }
        } else {
            $msg = "⚠ Please choose an image.";
        }
    } else {
        $msg = "⚠ Title, description, and image are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:#0f172a;
            color:white;
            padding:30px;
        }

        .container{
            max-width:700px;
            margin:0 auto;
            background:#111827;
            padding:30px;
            border-radius:18px;
            box-shadow:0 10px 30px rgba(0,0,0,.3);
        }

        .top-links{
            text-align:center;
            margin-bottom:20px;
        }

        .top-links a{
            color:#38bdf8;
            text-decoration:none;
            margin:0 10px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        .msg{
            text-align:center;
            margin-bottom:15px;
            padding:12px;
            border-radius:8px;
            background:#1e293b;
            color:#e2e8f0;
        }

        form{
            display:flex;
            flex-direction:column;
            gap:14px;
        }

        input, textarea{
            width:100%;
            padding:13px;
            border:none;
            border-radius:10px;
            font-size:15px;
            outline:none;
        }

        textarea{
            min-height:140px;
            resize:vertical;
        }

        input[type="file"]{
            background:white;
            color:black;
        }

        button{
            padding:14px;
            border:none;
            border-radius:10px;
            background:#38bdf8;
            color:black;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        button:hover{
            background:#0ea5e9;
        }

        .note{
            font-size:13px;
            color:#cbd5e1;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="top-links">
            <a href="index.php">Home</a>
            <a href="projects.php">Project List</a>
            <a href="logout.php">Logout</a>
        </div>

        <h2>Add New Project</h2>

        <?php if (!empty($msg)) { ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Project Title" required>

            <textarea name="description" placeholder="Project Description" required></textarea>

            <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp" required>
            <div class="note">Allowed: jpg, jpeg, png, gif, webp | Max: 5MB</div>

            <input type="text" name="tech" placeholder="Tech Stack (example: HTML, CSS, PHP, MySQL)">

            <button type="submit">Add Project</button>
        </form>
    </div>

</body>
</html>