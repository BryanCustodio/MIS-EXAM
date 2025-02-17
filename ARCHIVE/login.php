<?php
session_start();
include '../db/dbcon.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (isset($_POST['register'])) {
        // Registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($role == 'student') {
            $conn->query("INSERT INTO students (email, password) VALUES ('$email', '$hashedPassword')");
            $response = ["status" => "success", "message" => "Student registration successful!"];
        } elseif ($role == 'admin') {
            $conn->query("INSERT INTO admin (username, password) VALUES ('$email', '$hashedPassword')");
            $response = ["status" => "success", "message" => "Admin registration successful!"];
        }
    } elseif (isset($_POST['login'])) {
        // Login
        if ($role == 'student') {
            $result = $conn->query("SELECT * FROM students WHERE email='$email'");
        } else {
            $result = $conn->query("SELECT * FROM admin WHERE username='$email'");
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                if ($role == 'student') {
                    $_SESSION['student_logged_in'] = true;
                    $_SESSION['student_id'] = $row['id'];
                    $response = ["status" => "success", "redirect" => "student.php"];
                } else {
                    $_SESSION['admin_logged_in'] = true;
                    $response = ["status" => "success", "redirect" => "admin.php"];
                }
            } else {
                $response = ["status" => "error", "message" => "Invalid credentials!"];
            }
        } else {
            $response = ["status" => "error", "message" => "No user found!"];
        }
    }
}

echo json_encode($response);
?>
