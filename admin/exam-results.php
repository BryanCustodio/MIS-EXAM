<?php
include '../db/dbcon.php';

$query = "
    SELECT 
        s.first_name, s.last_name, 
        e.exam_name, 
        COUNT(sa.id) AS total_questions,
        SUM(sa.is_correct) AS correct_answers
    FROM student_answers sa
    JOIN student s ON sa.student_id = s.id
    JOIN exams e ON sa.exam_id = e.id
    GROUP BY sa.student_id, sa.exam_id
    ORDER BY s.last_name ASC, e.exam_name ASC
";

$results = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exam Results</title>
    <style>
        h2 {
            text-align: center;
            color: #333;
        }

        .results-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e8f5e9;
        }
    </style>
</head>
<body>

<div class="results-container">
    <h2>Exam Results</h2>
    <table>
        <tr>
            <th>Employees Name</th>
            <th>Exam Taken</th>
            <th>Score</th>
        </tr>
        <?php while ($row = $results->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['exam_name']; ?></td>
                <td><?php echo $row['correct_answers'] . '/' . $row['total_questions']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
