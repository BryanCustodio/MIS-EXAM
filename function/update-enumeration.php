<?php
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
//     $id = intval($_POST['id']);
//     $enum_question = $conn->real_escape_string($_POST['enum_question']);
//     $enum_answers = $conn->real_escape_string($_POST['enum_answers']);

//     $stmt = $conn->prepare("UPDATE enumeration_questions SET enumeration_text = ?, answers = ? WHERE id = ?");
//     $stmt->bind_param("ssi", $enum_question, $enum_answers, $id);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "error";
//     }

//     $stmt->close();
// }

// $conn->close();
?>
<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $enum_question = $conn->real_escape_string($_POST['enum_question']);
    $enum_answers = $conn->real_escape_string($_POST['enum_answers']);

    $stmt = $conn->prepare("UPDATE questions SET question_text = ?, answer = ? WHERE id = ? AND question_type = 'enumeration'");
    $stmt->bind_param("ssi", $enum_question, $enum_answers, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}

$conn->close();
?>
