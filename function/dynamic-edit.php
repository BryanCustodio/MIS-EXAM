<?php
// include '../db/dbcon.php';

// if (isset($_POST['id'])) {
//     $id = $_POST['id'];
//     $question_text = $_POST['question_text'];
//     $option_a = $_POST['option_a'];
//     $option_b = $_POST['option_b'];
//     $option_c = $_POST['option_c'];
//     $option_d = $_POST['option_d'];
//     $correct_option = $_POST['correct_option'];

//     $stmt = $conn->prepare("UPDATE questions SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?");
//     $stmt->bind_param("ssssssi", $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $id);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "error";
//     }

//     $stmt->close();
//     $conn->close();
// }
?>
<?php
include '../db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $query = "UPDATE questions SET 
                question_text = '$question_text', 
                option_a = '$option_a', 
                option_b = '$option_b', 
                option_c = '$option_c', 
                option_d = '$option_d', 
                correct_option = '$correct_option' 
              WHERE id = '$id'";

    if ($conn->query($query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
