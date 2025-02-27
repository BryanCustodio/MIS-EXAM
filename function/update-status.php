<?php
include '../db/dbcon.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE exam_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>