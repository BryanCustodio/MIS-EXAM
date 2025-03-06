        $(document).ready(function() {
            $('#examRequestsTable').DataTable();
        });

        $(".approve-btn, .disapprove-btn").click(function() {
            var id = $(this).data("id");
            var action = $(this).hasClass("approve-btn") ? "Approved" : "Disapproved";

            $.ajax({
                url: "../function/update-status.php",
                type: "POST",
                data: { id: id, status: action },
                success: function(response) {
                    $("#row_" + id + " .status").text(action);
                    $("#row_" + id + " td:last-child").html("<span>" + action + "</span>");
                }
            });
        });