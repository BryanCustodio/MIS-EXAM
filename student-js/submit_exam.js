$(document).ready(function () {
    $(".box").click(function () {
        var examId = $(this).data("exam-id");
        $("#examId").val(examId);

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

    $("#examForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "../student-function/submit_exam.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $("#examModal").hide();
            },
        });
    });

    $(".close").click(function () {
        $("#examModal").hide();
    });
});
