<?php
session_start();
include '../db/dbcon.php';

// Fetch students
$query = "SELECT id, first_name, middle_name, last_name, gender, username, created_at FROM student ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!-- Add DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
    /* General container styling */
    .table-container {
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    /* Table styling */
    table {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
    }

    th {
        background: #00929E;
        color: white;
        text-align: center;
        padding: 10px;
    }

    td {
        padding: 8px;
        text-align: center;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        th, td {
            font-size: 12px;
            padding: 6px;
        }
    }

    /* Buttons */
    .btn {
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .add-btn {
        background: #28a745;
        color: white;
        margin-bottom: 15px;
        display: block;
        width: 100%;
        text-align: center;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        margin: auto;
    }

    .close {
        float: right;
        font-size: 22px;
        cursor: pointer;
    }

    /* Form Input */
    input {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>

<!-- Add Exam Button -->
<div class="table-container">
    <h2>Registered Students</h2>
    <button class="btn add-btn" id="createExamBtn">Create Exam</button>

    <table id="studentTable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Username</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo isset($row['middle_name']) ? htmlspecialchars($row['middle_name']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo isset($row['gender']) ? htmlspecialchars($row['gender']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Create Exam Modal -->
<div id="createExamModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Create New Exam</h2>
        <form id="createExamForm">
            <label for="exam_name">Exam Name:</label>
            <input type="text" id="exam_name" name="exam_name" required>

            <label for="mcq_count">Multiple-Choice Questions:</label>
            <input type="number" id="mcq_count" name="mcq_count" required>

            <label for="identification_count">Identification Questions:</label>
            <input type="number" id="identification_count" name="identification_count" required>

            <label for="enumeration_count">Enumeration Questions:</label>
            <input type="number" id="enumeration_count" name="enumeration_count" required>

            <button type="submit" class="btn add-btn">Create Exam</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#studentTable').DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,           
            searching: true,        
            ordering: true,         
            lengthMenu: [10, 25, 50, 100], 
            language: {
                search: " Search: ",
                lengthMenu: "Show _MENU_ entries per page",
                info: "Showing _START_ to _END_ of _TOTAL_ students",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "→",
                    previous: "←"
                }
            }
        });
    });

    // Show modal
    $("#createExamBtn").click(function () {
        $("#createExamModal").fadeIn();
    });

    // Close modal
    $(".close").click(function () {
        $("#createExamModal").fadeOut();
    });

    // Submit form
    $("#createExamForm").submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "../function/add-exam.php",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response === "success") {
                    alert("Exam successfully created!");
                    $("#createExamModal").fadeOut();
                    location.reload();
                } else {
                    alert("Failed to create exam.");
                }
            }
        });
    });
</script>
