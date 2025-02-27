<?php
include '../db/dbcon.php';

$id = $_GET['id'];
$conn->query("UPDATE exam_requests SET status='Disapproved' WHERE id=$id");

header("Location: ./approved-disapproved.php");
exit();
?>
