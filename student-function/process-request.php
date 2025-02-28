<?php
session_start();
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $exam_name = $_POST['exam_name'];

    // Check kung may existing request na
    $check_stmt = $conn->prepare("SELECT * FROM exam_requests WHERE student_id = ? AND exam_name = ?");
    $check_stmt->bind_param("is", $student_id, $exam_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You have already requested for this exam.";
    } else {
        $stmt = $conn->prepare("INSERT INTO exam_requests (student_id, exam_name, status) VALUES (?, ?, 'Pending')");
        $stmt->bind_param("is", $student_id, $exam_name);

        if ($stmt->execute()) {
            echo "Request submitted successfully.";
        } else {
            echo "Error submitting request.";
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
