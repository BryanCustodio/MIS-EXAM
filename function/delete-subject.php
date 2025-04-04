<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // First delete all questions associated with this subject
        $stmt = $conn->prepare("DELETE FROM questions WHERE subject_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Then delete the subject
        $stmt = $conn->prepare("DELETE FROM title WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Commit transaction
        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "error: " . $e->getMessage();
    }
}
?>
