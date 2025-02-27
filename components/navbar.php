<nav class="navbar">
<link rel="stylesheet" href="../css/navbar.css">

    <div class="navbar-container">
        <!-- <div class="navbar-brand">SMP TRAINEE</div> -->
        <div class="navbar-brand">
            <img src="../shin-etsu.png" alt="Logo" class="navbar-logo">
        </div>

        <ul class="navbar-links">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
                <!-- Admin Links -->
                <li><a href="#" class="menu-link" onclick="location.reload();">Dashboard</a></li>
                <li><a href="#" class="menu-link" data-page="../admin/update.php">Questions</a></li>
                <li><a href="#" class="menu-link" data-page="../admin/registered-stud.php">Student Lists</a></li>
                <li><a href="#" class="menu-link" data-page="../admin/exam-results.php">Exam Results</a></li>
                <li><a href="#" class="menu-link" data-page="../admin/approved-disapproved.php">Student Requests</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'] === true) : ?>
                <!-- Student Links -->
                <li><a href="#" class="menu-link" onclick="location.reload();">Dashboard</a></li>
                <li><a href="#" class="menu-link" data-page="../student/take_exam.php">Take Exam</a></li>
                <li><a href="#" class="menu-link" data-page="../student/view_result.php">My Results</a></li>
            <?php endif; ?>
        </ul>

        <div class="navbar-user">
            <span class="admin-name">
                <?php
                if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                    echo $_SESSION['username'];
                } elseif (isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'] === true) {
                    echo $_SESSION['username'];
                } else {
                    echo "Guest";
                }
                ?>
            </span>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</nav>
<style>
    .navbar-logo {
    height: 30px; /* Adjust height as needed */
    width: auto;
}
</style>