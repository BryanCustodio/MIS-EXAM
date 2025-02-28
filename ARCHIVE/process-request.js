    $(document).ready(function() {
        var studentId = "<?php echo isset($_SESSION['student_id']) ? $_SESSION['student_id'] : ''; ?>";
        
        if (!studentId) {
            console.error("Student ID is not set.");
            return;
        }

        function checkExamStatus() {
            $.ajax({
                url: "../student/process-request.php",
                type: "POST",
                data: { student_id: studentId },
                dataType: "json",
                success: function(response) {
                    $(".box").each(function() {
                        var examName = $(this).data("exam");

                        if (response && response[examName]) {
                            var examData = response[examName];

                            if (examData.status === "Approved") {
                                $(this).find(".join-text").text("Take the Exam").css("color", "green");
                                $(this).off("click").click(function() {
                                    window.location.href = "./take-exam.php?exam=" + encodeURIComponent(examName);
                                });
                            } else {
                                $(this).find(".join-text").text("For Approval").css("color", "red");
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching exam status:", error);
                }
            });
        }

        checkExamStatus();

        $(".box").click(function() {
            var examName = $(this).data("exam");

            $.ajax({
                url: "../student/process-request.php",
                type: "POST",
                data: { student_id: studentId, exam_name: examName },
                success: function(response) {
                    alert("For Approval. Please wait for admin approval.");
                    checkExamStatus();
                },
                error: function(xhr, status, error) {
                    console.error("Error submitting exam request:", error);
                }
            });
        });
    });