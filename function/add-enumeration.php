<?php
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $enum_question = $_POST['enum_question'];
//     $enum_answers = $_POST['enum_answers']; // Store as a comma-separated string

//     $query = "INSERT INTO enumeration_questions (enumeration_text, answers) VALUES ('$enum_question', '$enum_answers')";
    
//     if ($conn->query($query)) {
//         echo json_encode([
//             "id" => $conn->insert_id,
//             "enum_question" => $enum_question,
//             "enum_answers" => $enum_answers
//         ]);
//     } else {
//         echo json_encode(["error" => $conn->error]);
//     }
// }
?>
<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $conn->real_escape_string($_POST['subject_id']);
    $enum_question = $conn->real_escape_string($_POST['enum_question']);
    $enum_answers = $conn->real_escape_string($_POST['enum_answers']); // Store as a comma-separated string

    $query = "INSERT INTO questions (subject_id, question_text, question_type, answer) 
              VALUES ('$subject_id','$enum_question', 'enumeration', '$enum_answers')";
    
    if ($conn->query($query)) {
        echo json_encode([
            "id" => $conn->insert_id,
            "subject_id" => $subject_id,
            "enum_question" => $enum_question,
            "enum_answers" => $enum_answers
        ]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}
?>
