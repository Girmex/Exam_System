<?php
include 'db_connect.php';
	
	$qry = $conn->query("SELECT * from exam_list where id='".$_GET['id']."' ");
	if($qry){
		echo json_encode($qry->fetch_array());
	}
?>