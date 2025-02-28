<?php
include '../db/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $mcq_count = (int)$_POST['mcq_count'];
    $identification_count = (int)$_POST['identification_count'];
    $enumeration_count = (int)$_POST['enumeration_count'];

    // Insert exam into 'exams' table
    $stmt = $conn->prepare("INSERT INTO exams (exam_name) VALUES (?)");
    $stmt->bind_param("s", $exam_name);
    if (!$stmt->execute()) {
        echo "error";
        exit();
    }
    $exam_id = $stmt->insert_id;

    // Function to fetch random questions
    function fetch_random_questions($conn, $table, $column, $type, $count, $exam_id) {
        $query = "SELECT id FROM $table ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $count);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $question_id = $row['id'];
            $insertQuery = "INSERT INTO exam_questions (exam_id, question_type, question_id) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("isi", $exam_id, $type, $question_id);
            $insertStmt->execute();
        }
    }

    // Fetch random questions and insert into 'exam_questions'
    fetch_random_questions($conn, "questions", "question_text", "multiple_choice", $mcq_count, $exam_id);
    fetch_random_questions($conn, "identification_questions", "identification_text", "identification", $identification_count, $exam_id);
    fetch_random_questions($conn, "enumeration_questions", "enumeration_text", "enumeration", $enumeration_count, $exam_id);

    echo "success";
}
?>
