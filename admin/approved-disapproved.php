<?php
session_start();
include '../db/dbcon.php';

// Fetch students
$studentQuery = "SELECT id, first_name, middle_name, last_name, gender, username, created_at FROM student ORDER BY created_at DESC";
$studentResult = $conn->query($studentQuery);

// Fetch exams
$examQuery = "SELECT id, exam_name FROM exams ORDER BY created_at DESC";
$examResult = $conn->query($examQuery);
$exams = [];
while ($examRow = $examResult->fetch_assoc()) {
    $exams[] = $examRow;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Examination</title>

    <!-- DataTables CSS & jQuery -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .exam-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .exam-form input {
            flex: 1;
            min-width: 150px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .add-btn {
            background: #28a745;
            color: white;
        }
        th {
            background: #00929E;
            color: white;
            text-align: center;
            padding: 10px;
        }
        td {
            padding: 8px;
            text-align: center;
        }
        input[type="checkbox"] {
            transform: scale(1.3);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New Exam</h2>
    
    <!-- Exam Creation Form -->
    <form id="createExamForm" class="exam-form">
        <input type="text" id="exam_name" name="exam_name" placeholder="Exam Name" required>
        <input type="number" id="mcq_count" name="mcq_count" placeholder="Multiple-Choice Questions" required>
        <input type="number" id="identification_count" name="identification_count" placeholder="Identification Questions" required>
        <input type="number" id="enumeration_count" name="enumeration_count" placeholder="Enumeration Questions" required>
        <button type="submit" class="btn add-btn">Create Exam</button>
    </form>

    <h2>Student Exam Access</h2>
    <table id="studentTable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <?php foreach ($exams as $exam) : ?>
                    <th><?php echo htmlspecialchars($exam['exam_name']); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($student = $studentResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['last_name']); ?></td>

                    <?php foreach ($exams as $exam) : ?>
                        <td>
                            <input type="checkbox" class="exam-checkbox" 
                                   data-student-id="<?php echo $student['id']; ?>" 
                                   data-exam-id="<?php echo $exam['id']; ?>">
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#studentTable').DataTable();

        $("#createExamForm").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: "../function/add-exam.php",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.trim() === "success" ? "Exam successfully created!" : "Failed to create exam.");
                    location.reload();
                }
            });
        });

        $(".exam-checkbox").change(function () {
            let studentId = $(this).data("student-id");
            let examId = $(this).data("exam-id");
            let isChecked = $(this).prop("checked") ? 1 : 0;

            $.ajax({
                url: "../function/update_exam_status.php",
                type: "POST",
                data: { student_id: studentId, exam_id: examId, status: isChecked },
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script>

</body>
</html>
