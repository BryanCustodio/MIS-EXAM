$(document).on("click", ".delete-id-btn", function () {
    var row = $(this).closest("tr");
    var questionID = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This record will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../function/dynamic-delete-identification.php",
                type: "POST",
                data: { id: questionID },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        row.fadeOut(500, function () {
                            $(this).remove();
                        });
                        Swal.fire("Deleted!", "The record has been deleted.", "success");
                    } else {
                        Swal.fire("Error!", "Failed to delete record.", "error");
                    }
                },
                error: function () {
                    Swal.fire("Error!", "Something went wrong with the delete request.", "error");
                }
            });
        }
    });
});
