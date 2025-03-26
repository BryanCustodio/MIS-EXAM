<?php
// include '../db/dbcon.php';

// if (isset($_POST['exam_id'])) {
//     $exam_id = $_POST['exam_id'];

//     $examQuery = "SELECT exam_name FROM exams WHERE id = ?";
//     $stmt = $conn->prepare($examQuery);
//     $stmt->bind_param("i", $exam_id);
//     $stmt->execute();
//     $examResult = $stmt->get_result()->fetch_assoc();
    
//     $questionQuery = "SELECT q.id, q.question_text, q.question_type, q.option_a, q.option_b, q.option_c, q.option_d
//                       FROM questions q
//                       INNER JOIN exam_questions eq ON q.id = eq.question_id
//                       WHERE eq.exam_id = ?";
//     $stmt = $conn->prepare($questionQuery);
//     $stmt->bind_param("i", $exam_id);
//     $stmt->execute();
//     $questionResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//     echo json_encode(["exam_name" => $examResult['exam_name'], "questions" => $questionResult]);
// }
?>
<?php
include '../db/dbcon.php';

if (isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];

    $examQuery = "SELECT exam_name FROM exams WHERE id = ?";
    $stmt = $conn->prepare($examQuery);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $examResult = $stmt->get_result()->fetch_assoc();
    
    $questionQuery = "SELECT q.id, q.question_text, q.question_type, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_answer
                      FROM questions q
                      INNER JOIN exam_questions eq ON q.id = eq.question_id
                      WHERE eq.exam_id = ?";
    $stmt = $conn->prepare($questionQuery);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $questionResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["exam_name" => $examResult['exam_name'], "questions" => $questionResult]);
}
?>
