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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Entrance Exam System</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            max-width: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .input-field input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            outline: none;
            margin-bottom: 10px;
        } 
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #1c6a98;
        }
        .register-btn {
            margin-top: 15px;
            background: none;
            border: none;
            color: #2980b9;
            cursor: pointer;
            font-size: 16px;
        }
        .register-btn:hover {
            text-decoration: underline;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            width: 350px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Admin Login</h2>

    <form id="login-form" method="POST">
        <div class="input-field">
            <input type="text" name="username" placeholder="Admin Username" required>
        </div>
        <div class="input-field">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login" class="submit-btn">Login</button>
    </form>

    <button class="register-btn" onclick="openModal()">Student Registration</button>
</div>

<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Student Registration</h2>
        <form method="POST">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="student_register" class="submit-btn">Register</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('studentModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('studentModal').style.display = 'none';
    }
</script>

</body>
</html>
