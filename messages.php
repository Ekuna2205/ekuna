<?php
include 'db.php';
$result=$conn->query("SELECT * FROM contacts ORDER BY id DESC");
?>

<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr>

<?php while($row=$result->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['message'] ?></td>
</tr>
<?php } ?>

</table>