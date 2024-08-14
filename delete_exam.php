<?php 
include 'db_connect.php';
extract($_GET);
$get = $conn->query("SELECT * FROM questions where eid= ".$id)->fetch_array();
$delete = $conn->query("DELETE FROM exam_list where id= ".$id);
$delete1 = $conn->query("DELETE FROM questions where qid= ".$id);

if($delete)
	echo true;
?>