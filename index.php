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

// Handling login for both admin and student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    session_start();
    include './db/dbcon.php'; // Make sure the database connection is correct

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user is an admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $row['username'];
            header("Location: admin/admin.php");
            exit;
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    } else {
        // Check if user is a student
        $stmt = $conn->prepare("SELECT id, username, password FROM student WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['student_logged_in'] = true;
                $_SESSION['student_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Debugging: Echo a message to confirm redirection is happening
                echo "<script>console.log('Login successful, redirecting...');</script>";
                header("Location: student/student.php");
                exit;
            } else {
                echo "<script>alert('Incorrect password!');</script>";
            }
        } else {
            echo "<script>alert('Username not found!');</script>";
        }
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
            width: 300px;
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
        /* Improved Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.modal.show {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: #fff;
    padding: 50px;
    width: 380px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    animation: slideIn 0.3s ease-in-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-content h2 {
    margin-bottom: 15px;
    color: #333;
}

.modal-content input,
.modal-content select {
    width: 300px;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    outline: none;
    transition: all 0.3s ease-in-out;
}

.modal-content input:focus,
.modal-content select:focus {
    border-color: #2980b9;
    box-shadow: 0 0 5px rgba(41, 128, 185, 0.5);
}

.submit-btn {
    width: 100px;
    padding: 12px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.submit-btn:hover {
    background-color: #1c6a98;
}

.close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
    color: #555;
    transition: color 0.3s ease-in-out;
}

.close:hover {
    color: #c0392b;
}
.back-btn {
        width: 100%;
        padding: 10px;
        background-color: #ccc;
        color: #333;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s ease;
    }
    .back-btn:hover {
        background-color: #bbb;
    }

    </style>
</head>
<body>

<div class="form-container">
    <h2>HR Trainee Login</h2>

    <form id="login-form" action='index.php' method="POST">
        <div class="input-field">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-field">
            <input type="password" name="password" placeholder="Password" required>
            <button class="register-btn" onclick="openModal()">Student Registration</button>
        </div><br>
        <button type="submit" name="login" class="submit-btn">Login</button>
    </form>
</div>

<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Student Registration</h2>
        <form method="POST" id="studentForm">
            <input type="text" name="first_name" placeholder="First Name" required oninput="checkFields()">
            <input type="text" name="middle_name" placeholder="Middle Name" required oninput="checkFields()">
            <input type="text" name="last_name" placeholder="Last Name" required oninput="checkFields()">
            <input type="text" name="username" placeholder="Username" required oninput="checkFields()">
            <input type="password" name="password" placeholder="Password" required oninput="checkFields()">
            <select name="gender" required onchange="checkFields()">
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <button type="submit" name="student_register" class="submit-btn" id="registerBtn" style="display: none;">Register</button>
            <button type="button" class="back-btn" onclick="closeModal()">Back</button>
        </form>
    </div>
</div>


<script>
function openModal() {
    const modal = document.getElementById('studentModal');
    modal.classList.add('show');
}

function closeModal() {
    const modal = document.getElementById('studentModal');
    modal.classList.remove('show');
}

</script>
<script>
function checkFields() {
    const form = document.getElementById('studentForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    const registerBtn = document.getElementById('registerBtn');
    
    let allFilled = true;
    
    inputs.forEach(input => {
        if (input.value.trim() === '') {
            allFilled = false;
        }
    });

    if (allFilled) {
        registerBtn.style.display = "block"; // Show button when all fields are filled
    } else {
        registerBtn.style.display = "none"; // Hide button if any field is empty
    }
}
</script>

</body>
</html>
