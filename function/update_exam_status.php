<?php
include '../db/dbcon.php';

if (isset($_POST['student_id'], $_POST['exam_id'], $_POST['status'])) {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $status = $_POST['status'];

    // Insert or update exam access
    $query = "INSERT INTO student_exams (student_id, exam_id, status) 
              VALUES ('$student_id', '$exam_id', '$status') 
              ON DUPLICATE KEY UPDATE status='$status'";

    if ($conn->query($query)) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
}
?>
