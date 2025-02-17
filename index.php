<?php
session_start();
include './db/dbcon.php';


// Handling registration (OPTIONAL: Only if you allow admin registration)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Register admin only
    $conn->query("INSERT INTO admin (username, password) VALUES ('$email', '$password')");
    echo "<div class='success-message'>Admin registration successful!</div>";
}

// Handling login (ONLY ADMIN CAN LOGIN)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin WHERE username='$email'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin/admin.php");
            exit;
        } else {
            echo "<div class='error-message'>Invalid credentials for admin!</div>";
        }
    } else {
        echo "<div class='error-message'>Invalid credentials for admin!</div>";
    }
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
        }
        .form-container {
            background-color: white;
            padding: 40px;
            max-width: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .input-field input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            outline: none;
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
        .error-message, .success-message {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Admin Login</h2>

    <!-- Login Form (Only for Admin) -->
    <form id="login-form" method="POST">
        <div class="input-field">
            <input type="email" name="email" placeholder="Admin Email" required>
        </div>
        <div class="input-field">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login" class="submit-btn">Login</button>
    </form>
</div>

</body>
</html>
