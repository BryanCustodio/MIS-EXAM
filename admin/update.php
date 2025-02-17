<?php
include '../db/dbcon.php';
?>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="../css/update.css">

<style>
    .table-container {
        max-width: 100%;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin: 25px auto;
        overflow-x: auto;
    }

    table {
        width: 100%;
        font-size: 14px;
    }

    th {
        background: #00929E;
        color: white;
        text-align: center;
    }

    td {
        text-align: center;
        padding: 8px;
        word-break: break-word;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 13px;
        display: inline-block;
    }

    .edit-btn {
        background: #00929E;
        color: white;
    }

    .delete-btn {
        background: #034EA2;
        color: white;
    }

    .edit-btn:hover {
        background: #218838;
    }

    .delete-btn:hover {
        background: #c82333;
    }

    @media (max-width: 768px) {
        .table-container {
            padding: 10px;
        }

        table {
            font-size: 12px;
        }

        .btn {
            font-size: 12px;
            padding: 4px 8px;
        }
    }
</style>

<!-- Edit Question Modal -->
<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Question</h2>
        <form id="editQuestionForm">
            <input type="hidden" id="edit_id">
            <label>Question:</label>
            <input type="text" id="edit_question" required>

            <label>Option A:</label>
            <input type="text" id="edit_option_a" required>

            <label>Option B:</label>
            <input type="text" id="edit_option_b" required>

            <label>Option C:</label>
            <input type="text" id="edit_option_c" required>

            <label>Option D:</label>
            <input type="text" id="edit_option_d" required>

            <label>Correct Answer:</label>
            <select id="edit_correct_option">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>
</div>

<!-- CSS for Modal -->
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 40%;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 25px;
    cursor: pointer;
}
</style>


<!-- Responsive Table Wrapper -->
<div class="table-container">
    <h2 style="color: #333;">Multiple Choice</h2><br>
    <form id="addQuestionForm" method="POST" action="../function/add-questions.php" style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
        <input type="text" name="question_text" placeholder="Enter question" required style="flex: 1; min-width: 200px;">
        <input type="text" name="option_a" placeholder="Option A" required style="flex: 1; min-width: 100px;">
        <input type="text" name="option_b" placeholder="Option B" required style="flex: 1; min-width: 100px;">
        <input type="text" name="option_c" placeholder="Option C" required style="flex: 1; min-width: 100px;">
        <input type="text" name="option_d" placeholder="Option D" required style="flex: 1; min-width: 100px;">
        <select name="correct_option" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select>
        <button type="submit" style="background: #00929E; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer;">Add Question</button>
    </form>

     <table id="questionsTable" class="display responsive nowrap compact">
        <thead>
        <tr>
    <th style="text-align: center;">Question</th>
    <th style="text-align: center;">A</th>
    <th style="text-align: center;">B</th>
    <th style="text-align: center;">C</th>
    <th style="text-align: center;">D</th>
    <th style="text-align: center;">Correct</th>
    <th style="text-align: center;">Actions</th>
</tr>

        </thead>
        <tbody>
            <?php
            $query = $conn->query("SELECT * FROM questions");
            while ($row = $query->fetch_assoc()) {
                echo "<tr id='row_{$row['id']}'>
                    <td>{$row['question_text']}</td>
                    <td>{$row['option_a']}</td>
                    <td>{$row['option_b']}</td>
                    <td>{$row['option_c']}</td>
                    <td>{$row['option_d']}</td>
                    <td>{$row['correct_option']}</td>
                    <td>
                        <button class='btn edit-btn' data-id='{$row['id']}'>Edit</button>
                        <button class='btn delete-btn' data-id='{$row['id']}'>Delete</button>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
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
// Edit button functionality
$(document).on('click', '.edit-btn', function () {
        var row = $(this).closest('tr');
        var questionID = $(this).data('id');

        if ($(this).text() === "Edit") {
            // Convert cells to input fields
            row.find('td:not(:last-child)').each(function (index) {
                var originalText = $(this).text().trim();
                if (index === 5) { // Correct Option (Dropdown)
                    $(this).html(`
                        <select class="edit-correct">
                            <option value="A" ${originalText === 'A' ? 'selected' : ''}>A</option>
                            <option value="B" ${originalText === 'B' ? 'selected' : ''}>B</option>
                            <option value="C" ${originalText === 'C' ? 'selected' : ''}>C</option>
                            <option value="D" ${originalText === 'D' ? 'selected' : ''}>D</option>
                        </select>
                    `);
                } else {
                    $(this).html(`<input type="text" class="edit-input" value="${originalText}">`);
                }
            });

            // Change button text
            $(this).text("Save").removeClass("edit-btn").addClass("save-btn");
            row.find(".delete-btn").text("Cancel").removeClass("delete-btn").addClass("cancel-btn");
        }
    });

    // Save button functionality
    $(document).on('click', '.save-btn', function () {
        var row = $(this).closest('tr');
        var questionID = $(this).data('id');

        // Get updated values
        var updatedData = {
            id: questionID,
            question_text: row.find('.edit-input').eq(0).val(),
            option_a: row.find('.edit-input').eq(1).val(),
            option_b: row.find('.edit-input').eq(2).val(),
            option_c: row.find('.edit-input').eq(3).val(),
            option_d: row.find('.edit-input').eq(4).val(),
            correct_option: row.find('.edit-correct').val()
        };

        // AJAX request to update the database
        $.ajax({
            url: '../function/dynamic-edit.php',
            type: 'POST',
            data: updatedData,
            success: function (response) {
                if (response === "success") {
                    // Replace input fields with updated text
                    row.find('td:not(:last-child)').each(function (index) {
                        if (index === 5) { // Correct option
                            $(this).text(updatedData.correct_option);
                        } else {
                            $(this).text(Object.values(updatedData)[index + 1]);
                        }
                    });

                    // Restore button states
                    row.find('.save-btn').text("Edit").removeClass("save-btn").addClass("edit-btn");
                    row.find('.cancel-btn').text("Delete").removeClass("cancel-btn").addClass("delete-btn");
                } else {
                    alert("Error updating data!");
                }
            }
        });
    });

    // Cancel button functionality (restore original data)
    $(document).on('click', '.cancel-btn', function () {
        var row = $(this).closest('tr');

        // Restore original values
        row.find('input').each(function (index) {
            $(this).parent().text($(this).val());
        });

        var correctOption = row.find('.edit-correct').val();
        row.find('.edit-correct').parent().text(correctOption);

        // Restore button states
        row.find('.save-btn').text("Edit").removeClass("save-btn").addClass("edit-btn");
        row.find('.cancel-btn').text("Delete").removeClass("cancel-btn").addClass("delete-btn");
    });
});
</script>


<script src="../js/dynamic-add.js"></script>
<script src="../js/dynamic-delete.js"></script>