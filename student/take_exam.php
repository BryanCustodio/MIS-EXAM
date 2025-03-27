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

// Fetch available exams
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="exam-container">
        <h2>Available Exams</h2>
        <div class="exam-grid">
            <?php foreach ($exams as $exam) : ?>
                <div class="box" data-exam-id="<?php echo $exam['id']; ?>">
                    <?php echo htmlspecialchars($exam['exam_name']); ?>
                    <br><span class="join-text">Join the Examination</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for Exam -->
    <div id="examModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="examTitle"></h2>
            <form id="examForm">
                <input type="hidden" name="exam_id" id="exam_id">
                <div id="examQuestions"></div>
                <button type="submit">Submit Exam</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
    $(".box").click(function () {
        var examId = $(this).data("exam-id");
        
        $.ajax({
            url: "../student-function/fetch_exam.php",
            type: "POST",
            data: { exam_id: examId },
            success: function (response) {
                try {
                    var data = JSON.parse(response);
                    
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    $("#examTitle").text(data.exam_name);
                    $("#exam_id").val(examId);

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
                        } else {
                            questionsHtml += `<input type="text" name="question_${q.id}" placeholder="Your answer"><br>`;
                        }
                    });

                    $("#examQuestions").html(questionsHtml);
                    $("#examModal").fadeIn(); // Opens modal properly
                } catch (error) {
                    console.log("Error parsing JSON:", error);
                }
            }
        });
    });

    $(".close").click(function () {
        $("#examModal").fadeOut(); // Ensures modal closes properly
    });

    // $("#examForm").submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url: "../student-function/submit_exam.php",
    //         type: "POST",
    //         data: $(this).serialize(),
    //         success: function (response) {
    //             alert(response);
    //             $("#examModal").fadeOut(); // Closes modal after submission
    //         }
    //     });
    // });
    $("#examForm").submit(function (e) {
    e.preventDefault();
    
    // Disable submit button to prevent multiple submissions
    $(this).find('button[type="submit"]').prop('disabled', true).text('Submitting...');
    
    $.ajax({
        url: "../student-function/submit_exam.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                // Show success message with score
                alert(response.message);
                
                // Redirect to a results page or refresh the current page
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show error message
                alert(response.message || "An error occurred while submitting the exam.");
            }
            
            // Close the modal
            $("#examModal").fadeOut();
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("There was a problem submitting your exam. Please try again.");
            
            // Re-enable the submit button
            $("#examForm").find('button[type="submit"]').prop('disabled', false).text('Submit Exam');
        }
    });
});


    // Ensures modal does not open automatically on page load
    $("#examModal").hide();
});

    </script>

</body>
</html>

<style>
    /* General styling */
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }
    
    /* Exam grid styling */
    .exam-container { 
        text-align: center; 
        padding: 30px; 
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .exam-container h2 {
        color: #202124;
        margin-bottom: 25px;
        font-weight: 500;
    }
    
    .exam-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
        gap: 20px; 
        justify-content: center; 
        margin: 20px auto; 
    }
    
    .box { 
        width: 100%; 
        height: 140px; 
        background-color: white; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        border-radius: 8px; 
        cursor: pointer; 
        transition: 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        font-weight: 500;
        color: #202124;
    }
    
    .box:hover { 
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        transform: translateY(-2px);
    }
    
    .join-text { 
        font-size: 13px; 
        color: #5f6368; 
        margin-top: 8px; 
    }
    
    /* Modal styling - Google Forms inspired */
    .modal { 
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        background-color: rgba(0, 0, 0, 0.5); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        overflow-y: auto;
    }
    
    .modal-content { 
        background-color: white; 
        padding: 30px; 
        border-radius: 8px; 
        width: 70%; 
        max-width: 800px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-in-out;
    }
    
    .modal-content h2 {
        color: #202124;
        font-size: 28px;
        margin-bottom: 25px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .close { 
        float: right; 
        font-size: 24px; 
        cursor: pointer; 
        color: #5f6368;
        transition: color 0.2s;
    }
    
    .close:hover {
        color: #d93025;
    }
    
    /* Form elements styling */
    #examQuestions p {
        font-size: 16px;
        color: #202124;
        margin-top: 25px;
        margin-bottom: 15px;
        font-weight: 500;
    }
    
    #examQuestions {
        margin-bottom: 30px;
    }
    
    #examQuestions label {
        display: block;
        padding: 10px 15px;
        margin: 8px 0;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
        color: #202124;
    }
    
    #examQuestions label:hover {
        background-color: #f5f5f5;
    }
    
    #examQuestions input[type="radio"] {
        margin-right: 10px;
    }
    
    #examQuestions input[type="text"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #dadce0;
        border-radius: 4px;
        font-size: 16px;
        transition: border 0.2s;
    }
    
    #examQuestions input[type="text"]:focus {
        border-color: #1a73e8;
        outline: none;
        box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
    }
    
    #examForm button {
        background-color: #1a73e8;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s;
        float: right;
    }
    
    #examForm button:hover {
        background-color: #1669d9;
    }
    
    /* Question sections */
    .question-section {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-content {
            width: 90%;
            padding: 20px;
        }
        
        .exam-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
</style>



<!-- <script src="../student-js/submit_exam.js"></script> -->
