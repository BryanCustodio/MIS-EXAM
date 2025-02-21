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
});
