<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identification_text = $_POST['identification_text'];
    $answer = $_POST['answer'];

    $query = "INSERT INTO identification_questions (identification_text, answer) VALUES ('$identification_text', '$answer')";

    if ($conn->query($query) === TRUE) {
        $last_id = $conn->insert_id;  // Get the last inserted ID
        echo json_encode([
            "id" => $last_id,
            "identification_text" => $identification_text,
            "answer" => $answer
        ]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}
?>
