<?php 
include 'db_connect.php';
extract($_POST);
$insert = array();
foreach($user_id as $val){
	$insert[]=$conn->query("INSERT INTO exam_student_list set exam_id = $eid, user_id = ".$val);
	
}
if(count($user_id) == count($insert)){
	echo 1;
}