<?php
include '../db/dbcon.php';
$students = $conn->query("SELECT id, first_name FROM student");
?>

<h2>Registered Students</h2>
<table>
    <tr><th>ID</th><th>Email</th></tr>
    <?php while ($row = $students->fetch_assoc()) { ?>
        <tr><td><?php echo $row['id']; ?></td><td><?php echo $row['first_name']; ?></td></tr>
    <?php } ?>
</table>


archive
archive
archive
archive
archive
archive
archive