<?php
include 'db.php';
$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects List</title>
    <style>
        body{
            margin:0;
            padding:30px;
            background:#0f172a;
            color:white;
            font-family:Arial,sans-serif;
        }
        h2{
            text-align:center;
            margin-bottom:20px;
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
        table{
            width:100%;
            border-collapse:collapse;
            background:#111827;
        }
        th, td{
            padding:12px;
            border:1px solid #253046;
            text-align:left;
            vertical-align:top;
        }
        th{
            background:#38bdf8;
            color:#08111f;
        }
        img{
            width:120px;
            border-radius:8px;
        }
        .btn{
            display:inline-block;
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
            font-size:14px;
            margin-right:6px;
        }
        .edit{
            background:#22c55e;
            color:white;
        }
        .delete{
            background:#ef4444;
            color:white;
        }
    </style>
</head>
<body>
    <div class="top-links">
        <a href="index.html">Home</a>
        <a href="add_project.php">Add Project</a>
        <a href="messages.php">Messages</a>
    </div>

    <h2>All Projects</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Tech</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo htmlspecialchars($row["title"]); ?></td>
            <td><?php echo htmlspecialchars($row["description"]); ?></td>
            <td><img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="project"></td>
            <td><?php echo htmlspecialchars($row["tech"]); ?></td>
            <td><?php echo $row["created_at"]; ?></td>
            <td>
                <a class="btn edit" href="edit_project.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="btn delete" href="delete_project.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this project?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>