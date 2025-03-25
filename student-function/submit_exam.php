<?php
session_start();
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['student_id'])) {
        echo "Unauthorized access!";
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $exam_id = $_POST['exam_id']; // Ensure exam_id is included in the form submission
    $score = 0;
    $total_questions = 0;

    // Fetch correct answers
    $query = "SELECT id, question_type, correct_answer FROM questions WHERE id IN (" . implode(",", array_map('intval', array_keys($_POST))) . ")";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $question_id = $row['id'];
        $correct_answer = $row['correct_answer'];
        $total_questions++;

        if ($row['question_type'] == 'multiple_choice') {
            if (isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] == $correct_answer) {
                $score++;
            }
        } elseif ($row['question_type'] == 'identification' || $row['question_type'] == 'enumeration') {
            if (isset($_POST["question_$question_id"]) && strtolower(trim($_POST["question_$question_id"])) == strtolower(trim($correct_answer))) {
                $score++;
            }
        }
    }

    // Store score in database
    $stmt = $conn->prepare("INSERT INTO student_scores (student_id, exam_id, score, total_questions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $student_id, $exam_id, $score, $total_questions);

    if ($stmt->execute()) {
        echo "Exam submitted successfully! Your score: $score / $total_questions";
    } else {
        echo "Error submitting exam.";
    }

    $stmt->close();
    $conn->close();
}
?>
