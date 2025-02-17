<?php
include '../db/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_question'])) {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $stmt = $conn->prepare("INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
    $stmt->execute();

    echo "<p class='success'>Question added successfully!</p>";
}
?>

<h2>Manage Questions</h2>
<form method="POST">
    <input type="text" name="question_text" placeholder="Question" required>
    <input type="text" name="option_a" placeholder="Option A" required>
    <input type="text" name="option_b" placeholder="Option B" required>
    <input type="text" name="option_c" placeholder="Option C" required>
    <input type="text" name="option_d" placeholder="Option D" required>
    <select name="correct_option" required>
        <option value="">Select Correct Option</option>
        <option value="A">Option A</option>
        <option value="B">Option B</option>
        <option value="C">Option C</option>
        <option value="D">Option D</option>
    </select>
    <button type="submit" name="add_question">Add Question</button>
</form>
