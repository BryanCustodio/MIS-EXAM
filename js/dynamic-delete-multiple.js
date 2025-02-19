$(document).on("click", ".delete-btn", function () {
    var questionId = $(this).data("id");
    var row = $(this).closest("tr");

    Swal.fire({
        title: "Are you sure?",
        text: "This question will be permanently deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../function/dynamic-delete-multiple.php",
                type: "POST",
                data: { id: questionId },
                dataType: "text",
                success: function (response) {
                    console.log("Server Response:", response); // Debugging

                    if (response.trim() === "success") {
                        $("#questionsTable").DataTable().row(row).remove().draw();
                        Swal.fire("Deleted!", "The question has been removed.", "success");
                    } else {
                        Swal.fire("Error!", "Failed to delete the question: " + response, "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    Swal.fire("Error!", "An error occurred while deleting.", "error");
                }
            });
        }
    });
});
