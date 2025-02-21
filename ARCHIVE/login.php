<?php
session_start();
include './db/dbcon.php';

// Handling student registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_register'])) {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists! Choose a different one.');</script>";
    } else {
        // Insert new student
        $stmt = $conn->prepare("INSERT INTO student (first_name, middle_name, last_name, gender, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $middle_name, $last_name, $gender, $username, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Student registration successful!');</script>";
        } else {
            echo "<script>alert('Error in registration!');</script>";
        }
    }
    $stmt->close();
}

// Handling admin login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin/admin.php");
            exit;
        } else {
            echo "<script>alert('Invalid credentials for admin!');</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials for admin!');</script>";
    }
    $stmt->close();
}
?>
