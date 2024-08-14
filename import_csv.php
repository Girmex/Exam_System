<?php
include('db_connect.php');
if(isset($_FILES['csv_file'])) {
    $exam_id = $_POST['exam_id']; 
    $csv_file = $_FILES['csv_file']['tmp_name'];
    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $question = $data[0];
            $image_url = $data[1];
            $option1 = $data[2];
            $option2 = $data[3];
            $option3 = $data[4];
            $option4 = $data[5];
            $correct_answer = $data[6];
            $query = "INSERT INTO questions (question, image_url, option1, option2, option3, option4, correct_answer, eid) VALUES ('$question', '$image_url', '$option1', '$option2', '$option3', '$option4', '$correct_answer', '$exam_id')";
            if($conn->query($query) === TRUE) {
            } else {
                echo json_encode(['error' => 'Unable to open CSV file']);
            }
        }
        fclose($handle);
    }
    $conn->close();
    echo "success";
} else {
    echo json_encode(['error' => 'No CSV file uploaded']);
}
?>
