<?php
include 'db_connect.php';
$response = array();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $eid = $_POST['qid'];
    $id = $_POST['id']; 
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct_answer = $_POST['correct_answer'];
    $image_path = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$image_path = "http://localhost/oq/" . $target_file;
        } else {
            $response['status'] = 0;
            $response['message'] = "Error uploading image.";
            echo json_encode($response);
            exit;
        }
    }
    if(empty($id)) {
        $sql = "INSERT INTO questions (question, image_url, eid, option1, option2, option3, option4, correct_answer) VALUES ('$question', '$image_path','$eid', '$option1', '$option2', '$option3', '$option4', '$correct_answer')";
        $action = "inserted";
    } else {
        
        $sql = "UPDATE questions SET question='$question', image_url='$image_path', option1='$option1', option2='$option2', option3='$option3', option4='$option4', correct_answer='$correct_answer' WHERE id='$id' AND eid='$eid'";
        $action = "updated";
    }
    if($conn->query($sql) === TRUE) {
        $response['status'] = 1;
        $response['message'] = "Question $action successfully";
    } else {
        $response['status'] = 0;
        $response['message'] = "Error: " . $conn->error;
    }
} else {
    $response['status'] = 0;
    $response['message'] = "Form not submitted";
}
echo json_encode(array($response));
?>
