<?php
// include '../db/dbcon.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $id = $_POST['id'];

//     $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
//     $stmt->bind_param("i", $id);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "error";
//     }
// }
?>
<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo "error: ID not received";
        exit;
    }

    $id = intval($_POST['id']); // Convert to integer to avoid SQL injection

    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
