<?php
session_start();
include '../db/dbcon.php';

// Check if student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header("Location: ../index.php");
    exit();
}

// Get student ID (assuming it's stored in the session)
$student_id = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Page</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".box").click(function() {
                var examName = $(this).data("exam");
                var studentId = <?php echo $student_id; ?>;
                
                $.ajax({
                    url: "../student-function/process-request.php",
                    type: "POST",
                    data: { student_id: studentId, exam_name: examName },
                    success: function(response) {
                        alert("For Approval. Please wait for admin approval.");
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="exam-container">
        <h2>Welcome to the Exam</h2>
        <div class="exam-grid">
            <div class="box" data-exam="Examination 1">Examination 1<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 2">Examination 2<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 3">Examination 3<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 4">Examination 4<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 5">Examination 5<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 6">Examination 6<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 7">Examination 7<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 8">Examination 8<br><span class="join-text">Join the Examination</span></div>
            <div class="box" data-exam="Examination 9">Examination 9<br><span class="join-text">Join the Examination</span></div>
        </div>
    </div>
</body>
</html>

<style>
    .exam-container {
        text-align: center;
        padding: 20px;
    }
    .exam-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        justify-content: center;
        margin: 20px auto;
        max-width: 800px;
    }
    .box {
        width: 100%;
        height: 120px;
        background-color: #f0f0f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }
    .box:hover {
        background-color: #ddd;
    }
    .join-text {
        font-size: 12px;
        color: gray;
        margin-top: 5px;
    }
</style>
