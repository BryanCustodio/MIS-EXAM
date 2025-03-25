<?php
session_start();
include '../db/dbcon.php';

// Check if student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header("Location: ../index.php");
    exit();
}

// Get student ID from session
$student_id = $_SESSION['student_id'];

// Fetch exams that the student is allowed to take
$examQuery = "SELECT e.id, e.exam_name 
              FROM exams e
              INNER JOIN student_exams se ON e.id = se.exam_id
              WHERE se.student_id = ? AND se.status = 1";
$stmt = $conn->prepare($examQuery);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$examResult = $stmt->get_result();
$exams = $examResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Page</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="exam-container">
        <h2>Available Exams</h2>
        <div class="exam-grid">
            <?php if (!empty($exams)) : ?>
                <?php foreach ($exams as $exam) : ?>
                    <div class="box" data-exam-id="<?php echo $exam['id']; ?>">
                        <?php echo htmlspecialchars($exam['exam_name']); ?>
                        <br><span class="join-text">Join the Examination</span>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No available exams at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Exam Modal -->
    <div id="examModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="examTitle"></h2>
            <form id="examForm">
                <div id="examQuestions"></div>
                <button type="submit">Submit Exam</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".box").click(function () {
                var examId = $(this).data("exam-id");

                // Fetch exam questions via AJAX
                $.ajax({
                    url: "../student-function/fetch_exam.php",
                    type: "POST",
                    data: { exam_id: examId },
                    success: function (response) {
                        var data = JSON.parse(response);

                        $("#examTitle").text(data.exam_name);

                        var questionsHtml = "";
                        data.questions.forEach((q, index) => {
                            questionsHtml += `<p>${index + 1}. ${q.question_text}</p>`;

                            if (q.question_type === "multiple_choice") {
                                questionsHtml += `
                                    <label><input type="radio" name="question_${q.id}" value="A"> ${q.option_a}</label><br>
                                    <label><input type="radio" name="question_${q.id}" value="B"> ${q.option_b}</label><br>
                                    <label><input type="radio" name="question_${q.id}" value="C"> ${q.option_c}</label><br>
                                    <label><input type="radio" name="question_${q.id}" value="D"> ${q.option_d}</label><br>
                                `;
                            } else if (q.question_type === "identification") {
                                questionsHtml += `<input type="text" name="question_${q.id}" placeholder="Your answer"><br>`;
                            } else if (q.question_type === "enumeration") {
                                questionsHtml += `<textarea name="question_${q.id}" placeholder="List your answers"></textarea><br>`;
                            }
                        });

                        $("#examQuestions").html(questionsHtml);
                        $("#examModal").show();
                    },
                });
            });

            // Close modal
            $(".close").click(function () {
                $("#examModal").hide();
            });

            // Submit Exam
            $("#examForm").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "submit_exam.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response);
                        $("#examModal").hide();
                    },
                });
            });
        });
    </script>

</body>
</html>

<style>
    .exam-container { text-align: center; padding: 20px; }
    .exam-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; justify-content: center; margin: 20px auto; max-width: 800px; }
    .box { width: 100%; height: 120px; background-color: #f0f0f0; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; transition: 0.3s; }
    .box:hover { background-color: #ddd; }
    .join-text { font-size: 12px; color: gray; margin-top: 5px; }
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); }
    .modal-content { background-color: white; margin: 10% auto; padding: 20px; border-radius: 5px; width: 50%; }
    .close { float: right; font-size: 24px; cursor: pointer; }
</style>

<script src="../student-js/submit_exam.js"></script>
