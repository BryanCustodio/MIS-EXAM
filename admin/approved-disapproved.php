<?php
session_start();
include '../db/dbcon.php';

$query = "SELECT er.id, s.first_name, s.last_name, er.exam_name, er.status 
          FROM exam_requests er 
          JOIN student s ON er.student_id = s.id 
          ORDER BY er.request_date DESC";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="../css/update.css">

<style>
    .table-container {
        max-width: 100%;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
    .approve-btn {
        background: #00929E;
        color: white;
    }
    .disapprove-btn {
        background: #c82333;
        color: white;
    }
    .approve-btn:hover {
        background: #218838;
    }
    .disapprove-btn:hover {
        background: #a71d2a;
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

<div class="table-container">
    <h2 style="color: #333;">Student Exam Requests</h2>
    <table id="examRequestsTable" class="display responsive nowrap compact">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Exam Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr id="row_<?php echo htmlspecialchars($row['id']); ?>">
                    <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                    <td class="status"><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] === 'Pending') : ?>
                            <button class="btn approve-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>">Approve</button>
                            <button class="btn disapprove-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>">Disapprove</button>
                        <?php else : ?>
                            <span><?php echo htmlspecialchars($row['status']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#examRequestsTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });
</script>
<script src="../js/app-dis-status.js"></script>
