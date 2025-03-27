// $(document).ready(function () {
//     $(".box").click(function () {
//         var examId = $(this).data("exam-id");
//         $("#examId").val(examId);

//         $.ajax({
//             url: "../student-function/fetch_exam.php",
//             type: "POST",
//             data: { exam_id: examId },
//             success: function (response) {
//                 var data = JSON.parse(response);
//                 $("#examTitle").text(data.exam_name);

//                 var questionsHtml = "";
//                 data.questions.forEach((q, index) => {
//                     questionsHtml += `<p>${index + 1}. ${q.question_text}</p>`;

//                     if (q.question_type === "multiple_choice") {
//                         questionsHtml += `
//                             <label><input type="radio" name="question_${q.id}" value="A"> ${q.option_a}</label><br>
//                             <label><input type="radio" name="question_${q.id}" value="B"> ${q.option_b}</label><br>
//                             <label><input type="radio" name="question_${q.id}" value="C"> ${q.option_c}</label><br>
//                             <label><input type="radio" name="question_${q.id}" value="D"> ${q.option_d}</label><br>
//                         `;
//                     } else if (q.question_type === "identification") {
//                         questionsHtml += `<input type="text" name="question_${q.id}" placeholder="Your answer"><br>`;
//                     } else if (q.question_type === "enumeration") {
//                         questionsHtml += `<textarea name="question_${q.id}" placeholder="List your answers"></textarea><br>`;
//                     }
//                 });

//                 $("#examQuestions").html(questionsHtml);
//                 $("#examModal").show();
//             },
//         });
//     });

//     $("#examForm").submit(function (e) {
//         e.preventDefault();
//         $.ajax({
//             url: "../student-function/submit_exam.php",
//             type: "POST",
//             data: $(this).serialize(),
//             success: function (response) {
//                 alert(response);
//                 $("#examModal").hide();
//             },
//         });
//     });

//     $(".close").click(function () {
//         $("#examModal").hide();
//     });
// });
// $(".box").click(function () {
//     var examId = $(this).data("exam-id");

//     $.ajax({
//         url: "../student-function/fetch_exam.php",
//         type: "POST",
//         data: { exam_id: examId },
//         success: function (response) {
//             var data = JSON.parse(response);

//             $("#examTitle").text(data.exam_name);
//             $("#exam_id").val(examId); // Assign exam_id to hidden input

//             var questionsHtml = "";
//             data.questions.forEach((q, index) => {
//                 questionsHtml += `<p>${index + 1}. ${q.question_text}</p>`;
//                 if (q.question_type === "multiple_choice") {
//                     questionsHtml += `
//                         <label><input type="radio" name="question_${q.id}" value="A"> ${q.option_a}</label><br>
//                         <label><input type="radio" name="question_${q.id}" value="B"> ${q.option_b}</label><br>
//                         <label><input type="radio" name="question_${q.id}" value="C"> ${q.option_c}</label><br>
//                         <label><input type="radio" name="question_${q.id}" value="D"> ${q.option_d}</label><br>
//                     `;
//                 } else {
//                     questionsHtml += `<input type="text" name="question_${q.id}" placeholder="Your answer"><br>`;
//                 }
//             });

//             $("#examQuestions").html(questionsHtml);
//             $("#examModal").show();
//         },
//     });
// });
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
                    $("#examModal").css("display", "block");
                } catch (e) {
                    console.error("Invalid JSON response", response);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });

    $(".close").click(function () {
        $("#examModal").css("display", "none");
    });

    $(window).click(function (event) {
        if (event.target.id === "examModal") {
            $("#examModal").css("display", "none");
        }
    });
});
