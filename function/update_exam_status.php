<?php
include '../db/dbcon.php';

if (isset($_POST['student_id']) && isset($_POST['exam_id']) && isset($_POST['status'])) {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $status = $_POST['status'];

    // Check if the record exists
    $checkQuery = "SELECT * FROM student_exam_access WHERE student_id='$student_id' AND exam_id='$exam_id'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Update existing record
        $updateQuery = "UPDATE student_exam_access SET status='$status' WHERE student_id='$student_id' AND exam_id='$exam_id'";
        $conn->query($updateQuery);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO student_exam_access (student_id, exam_id, status) VALUES ('$student_id', '$exam_id', '$status')";
        $conn->query($insertQuery);
    }

    echo "success";
}
?>
<?php
include '../db/dbcon.php';

if (isset($_POST['student_id']) && isset($_POST['exam_id']) && isset($_POST['status'])) {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $status = $_POST['status'];

    // Check if the record exists
    $checkQuery = "SELECT * FROM student_exams WHERE student_id='$student_id' AND exam_id='$exam_id'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Update existing record
        $updateQuery = "UPDATE student_exams SET status='$status' WHERE student_id='$student_id' AND exam_id='$exam_id'";
        $conn->query($updateQuery);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO student_exams (student_id, exam_id, status) VALUES ('$student_id', '$exam_id', '$status')";
        $conn->query($insertQuery);
    }

    echo "success";
}
?>
