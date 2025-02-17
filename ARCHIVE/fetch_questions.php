<?php
include '../db/dbcon.php';

$query = $conn->query("SELECT * FROM questions");
$data = [];

while ($row = $query->fetch_assoc()) {
    $data[] = [
        "question_text" => $row['question_text'],
        "option_a" => $row['option_a'],
        "option_b" => $row['option_b'],
        "option_c" => $row['option_c'],
        "option_d" => $row['option_d'],
        "correct_option" => $row['correct_option'],
        "actions" => "<button class='edit-btn' data-id='{$row['id']}'>Edit</button>
                      <button class='delete-btn' data-id='{$row['id']}'>Delete</button>"
    ];
}

echo json_encode(["data" => $data]);
?>
