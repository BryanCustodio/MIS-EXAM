<?php
include '../db/dbcon.php';

$id = $_GET['id'];
$conn->query("UPDATE exam_requests SET status='Approved' WHERE id=$id");

header("Location: ./approved-disapproved.php");
exit();
?>
