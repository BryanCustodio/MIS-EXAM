<?php
include '../db/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $mcq_count = (int)$_POST['mcq_count'];
    $identification_count = (int)$_POST['identification_count'];
    $enumeration_count = (int)$_POST['enumeration_count'];

    // Insert Exam
    $stmt = $conn->prepare("INSERT INTO exams (exam_name) VALUES (?)");
    $stmt->bind_param("s", $exam_name);
    
    if (!$stmt->execute()) {
        echo "error";
        exit();
    }
    $exam_id = $stmt->insert_id;

    // Function to Insert Questions
    function insertQuestions($conn, $table, $type, $count, $exam_id) {
        $query = "SELECT id FROM $table ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $count);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $insertStmt = $conn->prepare("INSERT INTO exam_questions (exam_id, question_id, question_type) VALUES (?, ?, ?)");
            $insertStmt->bind_param("iis", $exam_id, $row['id'], $type);
            $insertStmt->execute();
        }
    }

    // Insert different question types
    insertQuestions($conn, "questions", "multiple_choice", $mcq_count, $exam_id);
    insertQuestions($conn, "questions", "identification", $identification_count, $exam_id);
    insertQuestions($conn, "questions", "enumeration", $enumeration_count, $exam_id);

    echo "success";
}
?>
