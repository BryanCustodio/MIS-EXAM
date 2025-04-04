<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['subject_name'])) {
    $id = $_POST['id'];
    $subject_name = $_POST['subject_name'];
    
    $stmt = $conn->prepare("UPDATE title SET subject_name = ? WHERE id = ?");
    $stmt->bind_param("si", $subject_name, $id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
