$(document).on("click", ".enum-delete-btn", function () {
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
                url: "../function/dynamic-delete-enumeration.php",
                type: "POST",
                data: { id: questionId },
                dataType: "json",
                success: function (response) {
                    console.log("Server Response:", response); // Debugging

                    if (response.status.trim() === "success") {
                        row.css("background-color", "") // Light red background
                           .fadeOut(500, function () { // Smooth fade-out effect
                               $("#enumTable").DataTable().row(row).remove().draw();
                           });

                        Swal.fire("Deleted!", "The question has been removed.", "success");
                    } else {
                        Swal.fire("Error!", "Failed to delete the question: " + response.message, "error");
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
