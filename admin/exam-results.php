<?php
include '../db/dbcon.php';
$results = $conn->query("SELECT students.email, results.score FROM results JOIN students ON results.student_id = students.id");
?>

<h2>Exam Results</h2>
<table>
    <tr><th>Student Email</th><th>Score</th></tr>
    <?php while ($row = $results->fetch_assoc()) { ?>
        <tr><td><?php echo $row['email']; ?></td><td><?php echo $row['score']; ?></td></tr>
    <?php } ?>
</table>
