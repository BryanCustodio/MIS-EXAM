<?php
// include '../db/dbcon.php';

// header('Content-Type: application/json'); // Ensure JSON response

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
//     $id = intval($_POST['id']);

//     if ($id > 0) {
//         $stmt = $conn->prepare("DELETE FROM enumeration_questions WHERE id = ?");
//         $stmt->bind_param("i", $id);

//         if ($stmt->execute()) {
//             echo json_encode(["status" => "success"]);
//         } else {
//             echo json_encode(["status" => "error", "message" => $conn->error]);
//         }

//         $stmt->close();
//     } else {
//         echo json_encode(["status" => "error", "message" => "Invalid ID"]);
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "Missing ID"]);
// }

// $conn->close();
?>
<?php
include '../db/dbcon.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM questions WHERE id = ? AND question_type = 'enumeration'");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing ID"]);
}

$conn->close();
?>
