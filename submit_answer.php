<?php
include 'db_connect.php';
session_start();
header('Content-Type: application/json');
if ( isset($_POST['formData'])) {
    $exam_id = $_POST['exam_id'];
    parse_str($_POST['formData'], $formData);
    $questionQuery = $conn->query("SELECT id, correct_answer FROM questions WHERE eid = '$exam_id'");
    if (!$questionQuery) {
        die(json_encode(array('status' => 0, 'message' => 'Error executing query: ' . $conn->error)));
    }
    $totalQuestions = $questionQuery->num_rows;
    $score = 0;
    $answersDetails = array();
    while ($questions = $questionQuery->fetch_assoc()) {
        $questionId = $questions['id'];
        $correctAnswer = $questions['correct_answer'];
        if (isset($formData['option_id'][$questionId])) {
            $submittedAnswer = $formData['option_id'][$questionId];
            if ($submittedAnswer == $correctAnswer) {
                $score++;
            }
                 $answersDetails[$questionId] = array(
                'submitted' => $submittedAnswer,
                'correct' => $correctAnswer
            );
        }
    }
    $userId = $_SESSION['login_id'];
    $Status="taken";
    $insertQuery = $conn->query("INSERT INTO history (exam_id, user_id, status, score, total_score) VALUES ('$exam_id', '$userId','$Status', '$score', '$totalQuestions')");
    if ($insertQuery) {
        echo json_encode(array('status' => 1, 'score' => $score, 'answers' => $answersDetails));
    } else {
        echo json_encode(array('status' => 0, 'message' => 'Failed to insert data: ' . $conn->error));
    }
} else {
    echo json_encode(array('status' => 0, 'message' => 'Exam ID or form data not provided.'));
}
?>
