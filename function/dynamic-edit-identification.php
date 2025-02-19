<?php
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Ensure that the required data is being sent
//     if (isset($_POST['id'], $_POST['identification_text'], $_POST['answer'])) {
//         $id = $_POST['id'];
//         $identification_text = $_POST['identification_text'];
//         $answer = $_POST['answer'];

//         // Prepare the SQL query
//         $query = "UPDATE identification_questions SET 
//                     identification_text = '$identification_text', 
//                     answer = '$answer' 
//                   WHERE id = '$id'";

//         // Check if the query executed successfully
//         if ($conn->query($query)) {
//             // Respond with the updated data in JSON format
//             echo json_encode([
//                 "status" => "success",
//                 "id" => $id,
//                 "identification_text" => $identification_text,
//                 "answer" => $answer
//             ]);
//         } else {
//             // If there was an error, return the error message
//             echo json_encode(["status" => "error", "message" => $conn->error]);
//         }
//     } else {
//         echo json_encode(["status" => "error", "message" => "Missing required data."]);
//     }
// }
?>
<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['identification_text'], $_POST['answer'])) {
        $id = intval($_POST['id']); // Security: Convert to integer
        $identification_text = trim($_POST['identification_text']);
        $answer = trim($_POST['answer']);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("UPDATE identification_questions SET identification_text = ?, answer = ? WHERE id = ?");
        $stmt->bind_param("ssi", $identification_text, $answer, $id);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "id" => $id,
                "identification_text" => $identification_text,
                "answer" => $answer
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required data."]);
    }
}
?>
