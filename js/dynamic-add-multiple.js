// document.getElementById('addQuestionForm').addEventListener('submit', function(e) {
//     e.preventDefault();  // Prevent page reload

//     let formData = new FormData(this);

//     fetch('../function/add-multiple.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.json())  // Expecting JSON response
//     .then(data => {
//         if (data.error) {
//             Swal.fire("Error!", data.error, "error");
//         } else {
//             // Append new question dynamically to the table
//             let newRow = `
//                 <tr id="row_${data.id}">
//                     <td>${data.question_text}</td>
//                     <td>${data.option_a}</td>
//                     <td>${data.option_b}</td>
//                     <td>${data.option_c}</td>
//                     <td>${data.option_d}</td>
//                     <td>${data.correct_option}</td>
//                     <td>
//                         <button class="edit-btn" 
//                             data-id="${data.id}" 
//                             data-question="${data.question_text}" 
//                             data-a="${data.option_a}" 
//                             data-b="${data.option_b}" 
//                             data-c="${data.option_c}" 
//                             data-d="${data.option_d}" 
//                             data-correct="${data.correct_option}">
//                             Edit
//                         </button>
//                         <button class="delete-btn" data-id="${data.id}">Delete</button>
//                     </td>
//                 </tr>
//             `;

//             document.querySelector("#questionsTable tbody").insertAdjacentHTML("beforeend", newRow);

//             // Show success message
//             Swal.fire("Success!", "Question added successfully!", "success");

//             // Close the modal
//             closeAddModal();

//             // Clear form fields
//             document.getElementById('addQuestionForm').reset();
//         }
//     })
//     .catch(error => {
//         console.error("Error:", error);
//     });
// });
$(document).ready(function () {
    $("#addQuestionForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: "../function/add-multiple.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.id) {
                    // Create a new row dynamically
                    var newRow = `
                        <tr id="row_${response.id}">
                            <td>${response.question_text}</td>
                            <td>${response.option_a}</td>
                            <td>${response.option_b}</td>
                            <td>${response.option_c}</td>
                            <td>${response.option_d}</td>
                            <td>${response.correct_option}</td>
                            <td>
                                <button class="btn edit-btn" data-id="${response.id}">Edit</button>
                                <button class="btn delete-btn" data-id="${response.id}">Delete</button>
                            </td>
                        </tr>`;

                    // Append the new row to the table
                    $("#questionsTable tbody").append(newRow);

                    // Reset the form
                    $("#addQuestionForm")[0].reset();
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
