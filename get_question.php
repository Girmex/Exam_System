<?php
include 'db_connect.php';
$data = array();
$id = $_GET['id'];
$qry = $conn->query("SELECT id, question, option1, option2, option3, option4, correct_answer FROM questions WHERE id = $id");
$row = $qry->fetch_assoc();
if ($row) {
    $data['qdata'] = $row;
}
echo json_encode($data);
?>