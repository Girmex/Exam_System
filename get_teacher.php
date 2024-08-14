<?php
include 'db_connect.php';
	
	$qry = $conn->query("SELECT t.*,u.name,u.id as uid,u.username,u.password from teachers t left join users u  on t.user_id = u.id where t.id='".$_GET['id']."' ");
	if($qry){
		echo json_encode($qry->fetch_array());
	}
?>