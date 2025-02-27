<?php
session_start();
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $exam_status = [];

    $stmt = $conn->prepare("SELECT exam_name, status FROM exam_requests WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $exam_status[$row['exam_name']] = ['status' => $row['status']];
    }

    echo json_encode($exam_status);
    $stmt->close();
    $conn->close();
}
?>
