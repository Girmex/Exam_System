<?php 
include 'db_connect.php';
extract($_GET);
$delete = $conn->query("DELETE FROM exam_student_list where  id=".$eid);
if($delete)
	echo true;
?>