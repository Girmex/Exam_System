<?php 

include 'db_connect.php';

extract($_POST);

if(empty($id)){
	$data=  " title='".$title."'";
	$data .=  ", user_id='".$user_id."'";
	$data .=  ", qpoints='".$qpoints."'";
	$insert_user = $conn->query('INSERT INTO exam_list set  '.$data);

	if($insert_user){
			echo json_encode(array('status'=>1,'id'=>$conn->insert_id));
		
	}
}else{
	$data=  " title='".$title."'";
	$data .=  ", user_id='".$user_id."'";
	$data .=  ", qpoints='".$qpoints."'";
	$update = $conn->query('UPDATE exam_list set  '.$data.' where id= '.$id);

	if($update){
			echo json_encode(array('status'=>1,'id'=>$id));
		
	}
}