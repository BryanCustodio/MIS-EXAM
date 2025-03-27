<?php
// session_start();
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (!isset($_SESSION['student_id'])) {
//         echo "Unauthorized access!";
//         exit();
//     }

//     $student_id = $_SESSION['student_id'];
//     $exam_id = $_POST['exam_id']; // Ensure exam_id is included in the form submission
//     $score = 0;
//     $total_questions = 0;

//     // Fetch correct answers
//     $query = "SELECT id, question_type, correct_answer FROM questions WHERE id IN (" . implode(",", array_map('intval', array_keys($_POST))) . ")";
//     $result = $conn->query($query);

//     while ($row = $result->fetch_assoc()) {
//         $question_id = $row['id'];
//         $correct_answer = $row['correct_answer'];
//         $total_questions++;

//         if ($row['question_type'] == 'multiple_choice') {
//             if (isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] == $correct_answer) {
//                 $score++;
//             }
//         } elseif ($row['question_type'] == 'identification' || $row['question_type'] == 'enumeration') {
//             if (isset($_POST["question_$question_id"]) && strtolower(trim($_POST["question_$question_id"])) == strtolower(trim($correct_answer))) {
//                 $score++;
//             }
//         }
//     }

//     // Store score in database
//     $stmt = $conn->prepare("INSERT INTO student_scores (student_id, exam_id, score, total_questions) VALUES (?, ?, ?, ?)");
//     $stmt->bind_param("iiii", $student_id, $exam_id, $score, $total_questions);

//     if ($stmt->execute()) {
//         echo "Exam submitted successfully! Your score: $score / $total_questions";
//     } else {
//         echo "Error submitting exam.";
//     }

//     $stmt->close();
//     $conn->close();
// }
?>
<?php
// session_start();
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (!isset($_SESSION['student_id'])) {
//         echo "Unauthorized access!";
//         exit();
//     }

//     $student_id = $_SESSION['student_id'];
//     $exam_id = $_POST['exam_id'];
//     $score = 0;
//     $total_questions = 0;

//     $question_ids = array_keys($_POST);
//     array_shift($question_ids); // Remove exam_id

//     $query = "SELECT id, question_type, correct_answer FROM questions WHERE id IN (" . implode(",", array_map('intval', $question_ids)) . ")";
//     $result = $conn->query($query);

//     while ($row = $result->fetch_assoc()) {
//         $question_id = $row['id'];
//         $correct_answer = $row['correct_answer'];
//         $total_questions++;

//         if (isset($_POST["question_$question_id"]) && strtolower(trim($_POST["question_$question_id"])) == strtolower(trim($correct_answer))) {
//             $score++;
//         }
//     }

//     $stmt = $conn->prepare("INSERT INTO student_scores (student_id, exam_id, score, total_questions) VALUES (?, ?, ?, ?)");
//     $stmt->bind_param("iiii", $student_id, $exam_id, $score, $total_questions);

//     if ($stmt->execute()) {
//         echo "Exam submitted successfully! Your score: $score / $total_questions";
//     } else {
//         echo "Error submitting exam.";
//     }

//     $stmt->close();
//     $conn->close();
// }
?>
<?php
session_start();
include '../db/dbcon.php';

// Ensure the student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to submit the exam."]);
    exit();
}

$student_id = $_SESSION['student_id'];
$exam_id = $_POST['exam_id'];

if (!$exam_id) {
    echo json_encode(["status" => "error", "message" => "Invalid exam submission."]);
    exit();
}

// Fetch all questions for the exam
$questionQuery = "SELECT q.id, q.correct_option, q.answer, q.question_type 
                  FROM questions q 
                  INNER JOIN exam_questions eq ON q.id = eq.question_id 
                  WHERE eq.exam_id = ?";
$stmt = $conn->prepare($questionQuery);
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Initialize variables
$total_questions = count($questions);
$correct_answers = 0;

// Start transaction
$conn->begin_transaction();

try {
    foreach ($questions as $question) {
        $question_id = $question['id'];
        $correct_option = $question['correct_option'];
        $correct_answer = $question['answer'];
        $question_type = $question['question_type'];

        // Get student answer
        $student_answer = isset($_POST["question_{$question_id}"]) ? trim($_POST["question_{$question_id}"]) : null;

        // Check correctness
        $is_correct = false;
        if ($question_type == "multiple_choice") {
            $is_correct = ($student_answer == $correct_option);
        } else {
            $is_correct = (strcasecmp($student_answer, $correct_answer) == 0);
        }

        // Insert into student_answers table
        $insertQuery = "INSERT INTO student_answers (student_id, exam_id, question_id, answer, is_correct) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiisi", $student_id, $exam_id, $question_id, $student_answer, $is_correct);
        $stmt->execute();

        if ($is_correct) {
            $correct_answers++;
        }
    }

    // Commit transaction
    $conn->commit();

    // Calculate score
    $score = round(($correct_answers / $total_questions) * 100, 2);
    echo json_encode(["status" => "success", "message" => "Exam submitted successfully! Your score: $score%"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Failed to submit exam. Please try again."]);
}
?>
