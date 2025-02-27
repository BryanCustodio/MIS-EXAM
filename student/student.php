<?php
session_start();
include '../db/dbcon.php';

// Check if student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: ../index.php"); // Redirect to login if not logged in
    exit();
}

// Get student username from session
$username = $_SESSION['username'];

// Fetch student details from the database
$stmt = $conn->prepare("SELECT first_name, last_name FROM student WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "<script>alert('Error: Student not found!'); window.location.href='../index.php';</script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="dashboard-container">
    <!-- Navbar -->
    <?php include '../components/navbar.php'; ?>

    <!-- Main Content Area -->
    <div class="main-content">
        <div id="dynamic-content">
            <h2>Welcome, <?php echo htmlspecialchars($student['first_name'] . " " . $student['last_name']); ?>!</h2>
            <p>Dashboard</p>
        </div>
    </div>
</div>

<script src="../js/dynamic-page.js"></script>

</body>
</html>
