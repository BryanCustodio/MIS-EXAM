<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subject_name'])) {
    $subject_name = $_POST['subject_name'];
    
    $stmt = $conn->prepare("INSERT INTO title (subject_name) VALUES (?)");
    $stmt->bind_param("s", $subject_name);
    
    if ($stmt->execute()) {
        header("Location: ../admin/update.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
