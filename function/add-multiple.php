<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $query = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) 
              VALUES ('$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";

    if ($conn->query($query) === TRUE) {
        $last_id = $conn->insert_id;  // Get the last inserted ID
        echo json_encode([
            "id" => $last_id,
            "question_text" => $question_text,
            "option_a" => $option_a,
            "option_b" => $option_b,
            "option_c" => $option_c,
            "option_d" => $option_d,
            "correct_option" => $correct_option
        ]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}
?>