<nav class="navbar">
<link rel="stylesheet" href="../css/navbar.css">

    <div class="navbar-container">
        <div class="navbar-brand">SMP TRAINEE</div>
        <ul class="navbar-links">
        <li><a href="#" class="menu-link" data-page="../admin/update.php">Questions</a></li>
        <li><a href="#" class="menu-link" data-page="../admin/registered-stud.php">Student Lists</a></li>
        <li><a href="#" class="menu-link" data-page="../admin/exam-results.php">Student Results</a></li>
        </ul>
        <div class="navbar-user">
            <span class="admin-name">
                <?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : "Admin"; ?>
            </span>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</nav>