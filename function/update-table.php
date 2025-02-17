<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $updateQuery = $conn->query("UPDATE questions SET 
        question_text='$question_text', 
        option_a='$option_a', 
        option_b='$option_b', 
        option_c='$option_c', 
        option_d='$option_d', 
        correct_option='$correct_option' 
        WHERE id='$id'");

    if ($updateQuery) {
        echo json_encode([
            "success" => true,
            "id" => $id,
            "question_text" => $question_text,
            "option_a" => $option_a,
            "option_b" => $option_b,
            "option_c" => $option_c,
            "option_d" => $option_d,
            "correct_option" => $correct_option
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
