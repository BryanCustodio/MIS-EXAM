<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $identification_text = $_POST['identification_text'];
    $answer = $_POST['answer'];

    // Gamitin ang prepared statements para sa mas ligtas na query
    $stmt = $conn->prepare("UPDATE identification_questions SET identification_text = ?, answer = ? WHERE id = ?");
    $stmt->bind_param("ssi", $identification_text, $answer, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>