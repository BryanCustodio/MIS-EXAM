<?php
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (!isset($_POST['id']) || empty($_POST['id'])) {
//         echo "error: ID not received";
//         exit;
//     }

//     $id = intval($_POST['id']); // Convert to integer to avoid SQL injection

//     $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
//     $stmt->bind_param("i", $id);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "error: " . $stmt->error;
//     }

//     $stmt->close();
//     $conn->close();
// }
?>
<?php
include '../db/dbcon.php';

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ids'])) {
    $ids = $_POST['ids']; // Ito ay array na ng IDs

    if (empty($ids)) {
        echo json_encode(["status" => "error", "message" => "No IDs received"]);
        exit;
    }

    // Convert array to comma-separated values (e.g., 1,2,3)
    $idList = implode(",", array_map('intval', $ids));

    // Siguraduhin walang SQL Injection
    $query = "DELETE FROM questions WHERE id IN ($idList)";

    if ($conn->query($query) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
