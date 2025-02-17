<?php
include '../db/dbcon.php';

if (isset($_POST['save_question'])) {
    $id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    if (!empty($id)) {
        // Update existing question
        $sql = "UPDATE questions SET question_text='$question_text', option_a='$option_a', option_b='$option_b', 
                option_c='$option_c', option_d='$option_d', correct_option='$correct_option' WHERE id=$id";
    } else {
        // Insert new question
        $sql = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) 
                VALUES ('$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin/update.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
