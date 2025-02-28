<?php
session_start();
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $exam_name = $_POST['exam_name'];

    // Check if the request already exists
    $checkQuery = "SELECT * FROM exam_requests WHERE student_id = ? AND exam_name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $student_id, $exam_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert request for approval
        $insertQuery = "INSERT INTO exam_requests (student_id, exam_name, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("is", $student_id, $exam_name);
        
        if ($stmt->execute()) {
            echo "For Approval. Please wait for admin approval.";
        } else {
            echo "Error submitting request.";
        }
    } else {
        echo "You have already requested approval for this exam.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
