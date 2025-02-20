// $(document).ready(function () {
//     $("#addQuestionForm").submit(function (event) {
//         event.preventDefault(); // Prevent the default form submission

//         $.ajax({
//             url: "../function/add-multiple.php",
//             type: "POST",
//             data: $(this).serialize(),
//             dataType: "json",
//             success: function (response) {
//                 if (response.id) {
//                     // Create a new row dynamically
//                     var newRow = `
//                         <tr id="row_${response.id}">
//                             <td>${response.question_text}</td>
//                             <td>${response.option_a}</td>
//                             <td>${response.option_b}</td>
//                             <td>${response.option_c}</td>
//                             <td>${response.option_d}</td>
//                             <td>${response.correct_option}</td>
//                             <td>
//                                 <button class="btn edit-btn" data-id="${response.id}">Edit</button>
//                                 <button class="btn delete-btn" data-id="${response.id}">Delete</button>
//                             </td>
//                         </tr>`;

//                     // Append the new row to the table
//                     $("#questionsTable tbody").append(newRow);

//                     // Reset the form
//                     $("#addQuestionForm")[0].reset();
//                 } else {
//                     alert("Error: " + response.error);
//                 }
//             },
//             error: function () {
//                 alert("Something went wrong!");
//             }
//         });
//     });
// });


// $(document).ready(function () {
//     var table = $('#questionsTable').DataTable({
//         responsive: true,
//         autoWidth: false,
//         pageLength: 5,
//         lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
//         columnDefs: [
//             { targets: [0], className: "text-wrap", width: "30%" },
//             { targets: [1, 2, 3, 4, 5], className: "text-center", width: "10%" },
//             { targets: [6], className: "text-center", width: "20%" }
//         ],
//         language: {
//             searchPlaceholder: "Search questions...",
//             lengthMenu: "Show _MENU_ entries",
//             zeroRecords: "No matching records found",
//             info: "Showing _START_ to _END_ of _TOTAL_ entries",
//             infoEmpty: "No records available",
//             infoFiltered: "(filtered from _MAX_ total records)",
//             paginate: {
//                 first: "First",
//                 last: "Last",
//                 next: "→",
//                 previous: "←"
//             }
//         }
//     });

//     $("#addQuestionForm").submit(function (event) {
//         event.preventDefault(); // Prevent default form submission

//         $.ajax({
//             url: "../function/add-multiple.php",
//             type: "POST",
//             data: $(this).serialize(),
//             dataType: "json",
//             success: function (response) {
//                 if (response.id) {
//                     // Add new row using DataTables API
//                     table.row.add([
//                         response.question_text,
//                         response.option_a,
//                         response.option_b,
//                         response.option_c,
//                         response.option_d,
//                         response.correct_option,
//                         `<button class="btn edit-btn" data-id="${response.id}">Edit</button>
//                          <button class="btn delete-btn" data-id="${response.id}">Delete</button>`
//                     ]).draw(false); // Draw the table without resetting pagination

//                     // Reset the form
//                     $("#addQuestionForm")[0].reset();
//                 } else {
//                     alert("Error: " + response.error);
//                 }
//             },
//             error: function () {
//                 alert("Something went wrong!");
//             }
//         });
//     });
// });


// $(document).ready(function () {
//     $("#addQuestionForm").submit(function (event) {
//         event.preventDefault(); // Prevent the default form submission

//         $.ajax({
//             url: "../function/add-multiple.php",
//             type: "POST",
//             data: $(this).serialize(),
//             dataType: "json",
//             success: function (response) {
//                 if (response.id) {
//                     // Create a new row dynamically
//                     var newRow = `
//                         <tr id="row_${response.id}">
//                             <td>${response.question_text}</td>
//                             <td>${response.option_a}</td>
//                             <td>${response.option_b}</td>
//                             <td>${response.option_c}</td>
//                             <td>${response.option_d}</td>
//                             <td>${response.correct_option}</td>
//                             <td>
//                                 <button class="btn edit-btn" data-id="${response.id}">Edit</button>
//                                 <button class="btn delete-btn" data-id="${response.id}">Delete</button>
//                             </td>
//                         </tr>`;

//                     // Append the new row to the table
//                     $("#questionsTable tbody").append(newRow);

//                     // Reset the form
//                     $("#addQuestionForm")[0].reset();
//                 } else {
//                     alert("Error: " + response.error);
//                 }
//             },
//             error: function () {
//                 alert("Something went wrong!");
//             }
//         });
//     });
// });


$(document).ready(function () {
    var table = $('#questionsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        columnDefs: [
            { targets: [0], className: "text-wrap", width: "30%" },
            { targets: [1, 2, 3, 4, 5], className: "text-center", width: "10%" },
            { targets: [6], className: "text-center", width: "20%" }
        ],
        language: {
            searchPlaceholder: "Search questions...",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)",
            paginate: {
                first: "First",
                last: "Last",
                next: "→",
                previous: "←"
            }
        }
    });

    // ADD QUESTION
    $("#addQuestionForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "../function/add-multiple.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.id) {
                    var newRow = table.row.add([
                        response.question_text,
                        response.option_a,
                        response.option_b,
                        response.option_c,
                        response.option_d,
                        response.correct_option,
                        `<button class="btn edit-btn" data-id="${response.id}" data-question="${response.question_text}" 
                         data-a="${response.option_a}" data-b="${response.option_b}" data-c="${response.option_c}" 
                         data-d="${response.option_d}" data-correct="${response.correct_option}">Edit</button>
                         
                         <button class="btn delete-btn" data-id="${response.id}">Delete</button>`
                    ]).draw(false).node(); // Hindi magre-reset ang pagination
                    
                    $(newRow).attr("data-id", response.id); // Para may unique identifier bawat row
                    
                    $("#addQuestionForm")[0].reset(); // I-reset ang form
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function () {
                alert("Something went wrong!");
            }
        });
    });

    // EDIT FUNCTION
    $(document).on("click", ".edit-btn", function () {
        var id = $(this).data("id");
        var question = $(this).data("question");
        var optionA = $(this).data("a");
        var optionB = $(this).data("b");
        var optionC = $(this).data("c");
        var optionD = $(this).data("d");
        var correctOption = $(this).data("correct");

        $("#editQuestionId").val(id);
        $("#editQuestion").val(question);
        $("#editOptionA").val(optionA);
        $("#editOptionB").val(optionB);
        $("#editOptionC").val(optionC);
        $("#editOptionD").val(optionD);
        $("#editCorrectOption").val(correctOption);

        $("#editQuestionModal").modal("show");
    });

    // UPDATE QUESTION
    $("#editQuestionForm").submit(function (event) {
        event.preventDefault();
        var id = $("#editQuestionId").val();

        $.ajax({
            url: "../function/update-question.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    var row = table.row($(`tr[data-id="${id}"]`));
                    row.data([
                        response.question_text,
                        response.option_a,
                        response.option_b,
                        response.option_c,
                        response.option_d,
                        response.correct_option,
                        `<button class="btn edit-btn" data-id="${response.id}" data-question="${response.question_text}" 
                         data-a="${response.option_a}" data-b="${response.option_b}" data-c="${response.option_c}" 
                         data-d="${response.option_d}" data-correct="${response.correct_option}">Edit</button>
                         
                         <button class="btn delete-btn" data-id="${response.id}">Delete</button>`
                    ]).draw(false); // Hindi magre-reset ang pagination
                    
                    $("#editQuestionModal").modal("hide"); // Isara ang modal
                } else {
                    alert("Error updating question: " + response.error);
                }
            },
            error: function () {
                alert("Something went wrong!");
            }
        });
    });
});
