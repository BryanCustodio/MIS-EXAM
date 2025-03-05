    $("#addEnumForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "../function/add-enumeration.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.id) {
                    var newRow = `
                        <tr id="enumRow_${response.id}">
                            <td>${response.enum_question}</td>
                            <td>${response.enum_answers}</td>
                            <td>
                                <button class="btn enum-edit-btn" data-id="${response.id}">Edit</button>
                                <button class="btn enum-delete-btn" data-id="${response.id}">Delete</button>
                            </td>
                        </tr>`;
                    
                    $("#enumTable tbody").append(newRow);
                    $("#addEnumForm")[0].reset();
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function () {
                alert("Something went wrong!");
            }
        });
    });