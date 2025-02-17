<?php
include '../db/dbcon.php';
$students = $conn->query("SELECT id, email FROM students");
?>

<h2>Registered Students</h2>
<table>
    <tr><th>ID</th><th>Email</th></tr>
    <?php while ($row = $students->fetch_assoc()) { ?>
        <tr><td><?php echo $row['id']; ?></td><td><?php echo $row['email']; ?></td></tr>
    <?php } ?>
</table>
