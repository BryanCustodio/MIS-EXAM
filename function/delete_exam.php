<?php
include '../db/dbcon.php';

if (isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];

    $deleteQuery = "DELETE FROM exams WHERE id='$exam_id'";
    if ($conn->query($deleteQuery)) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
}
?>
