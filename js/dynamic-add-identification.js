    // $("#addIdentificationForm").submit(function (event) {
    //     event.preventDefault();

    //     $.ajax({
    //         url: "../function/add-identification.php",
    //         type: "POST",
    //         data: $(this).serialize(),
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.id) {
    //                 var newRow = `
    //                     <tr id="identification_row_${response.id}">
    //                         <td>${response.identification_text}</td>
    //                         <td>${response.answer}</td>
    //                         <td>
    //                             <button class="btn edit-id-btn" data-id="${response.id}">Edit</button>
    //                             <button class="btn delete-id-btn" data-id="${response.id}">Delete</button>
    //                         </td>
    //                     </tr>`;
                    
    //                 $("#identificationTable tbody").append(newRow);
    //                 $("#addIdentificationForm")[0].reset();
    //             } else {
    //                 alert("Error: " + response.error);
    //             }
    //         },
    //         error: function () {
    //             alert("Something went wrong!");
    //         }
    //     });
    // });

    $("#addIdentificationForm").submit(function (event) {
        event.preventDefault();
    
        $.ajax({
            url: "../function/add-identification.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.id) {
                    var newRow = `
                        <tr id="identification_row_${response.id}">
                            <td>${response.question_text}</td>
                            <td>${response.answer}</td>
                            <td>
                                <button class="btn edit-id-btn" data-id="${response.id}">Edit</button>
                                <button class="btn delete-id-btn" data-id="${response.id}">Delete</button>
                            </td>
                        </tr>`;
                    $("#identificationTable tbody").append(newRow);
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
    