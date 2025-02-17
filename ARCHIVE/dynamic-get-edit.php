<?php
include '../db/dbcon.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = $conn->prepare("SELECT * FROM questions WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    if ($result) {
        echo json_encode(["success" => true, "data" => $result]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
