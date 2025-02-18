$(document).ready(function () {
    $("#addIdentificationForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "../function/add-identification.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.id) {
                    // Add the new row dynamically
                    var newRow = `
                        <tr id="identification_row_${response.id}">
                            <td>${response.identification_text}</td>
                            <td>${response.answer}</td>
                            <td>
                                <button class="btn edit-id-btn" data-id="${response.id}">Edit</button>
                                <button class="btn delete-id-btn" data-id="${response.id}">Delete</button>
                            </td>
                        </tr>`;
                    
                    $("#identificationTable tbody").append(newRow);
                    
                    // Clear input fields
                    $("#addIdentificationForm")[0].reset();
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
// Save button functionality
$(document).on('click', '.save-id-btn', function () {
    var row = $(this).closest('tr');
    var questionID = $(this).data('id'); // Retrieve questionID from data-id

    var updatedData = {
        id: questionID,
        identification_text: row.find('.edit-id-input').eq(0).val(),
        answer: row.find('.edit-id-input').eq(1).val()
    };

    $.ajax({
        url: '../function/dynamic-iden-edit.php',
        type: 'POST',
        data: updatedData,
        dataType: 'json', // Expecting JSON response
        success: function (response) {
            if (response.status === "success") {
                // Update the row dynamically with new data
                row.find('td:nth-child(1)').text(response.identification_text);
                row.find('td:nth-child(2)').text(response.answer);

                // Switch back to the Edit button state
                row.find('.save-id-btn').text("Edit").removeClass("save-id-btn").addClass("edit-id-btn");
                row.find('.cancel-id-btn').text("Delete").removeClass("cancel-id-btn").addClass("delete-id-btn");
            } else {
                alert("Error updating data: " + response.message);
            }
        },
        error: function () {
            alert("Something went wrong while saving!");
        }
    });
});
