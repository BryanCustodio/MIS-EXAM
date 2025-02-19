<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enum_question = $_POST['enum_question'];
    $enum_answers = $_POST['enum_answers']; // Store as a comma-separated string

    $query = "INSERT INTO enumeration_questions (enumeration_text, answers) VALUES ('$enum_question', '$enum_answers')";
    
    if ($conn->query($query)) {
        echo json_encode([
            "id" => $conn->insert_id,
            "enum_question" => $enum_question,
            "enum_answers" => $enum_answers
        ]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}
?>
