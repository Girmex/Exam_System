
<!DOCTYPE html>
<html lang="en">
<head>
	</head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<title>My Exam List</title>
</head>
<body style="display:flex">
	<div>
	<?php include('nav_bar.php') ?>
	</div>
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary">My Exam List</div>
		<br>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					<colgroup>
						<col width="10%">
						<col width="30%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Exam</th>
							<th>Score</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$qry = $conn->query("SELECT * from  exam_list where id in  (SELECT exam_id FROM exam_student_list where user_id ='".$_SESSION['login_id']."' ) order by title asc ");
					$i = 1;
					if($qry->num_rows > 0){
						while($row= $qry->fetch_assoc()){
							$status = $conn->query("SELECT * from history where exam_id = '".$row['id']."' and user_id ='".$_SESSION['login_id']."' ");
							$hist = $status->fetch_array();
						?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['title'] ?></td>
						<td><?php echo $status->num_rows > 0 ? $hist['score'].'/'.$hist['total_score'] : 'N/A' ?></td>
						<td><?php echo $status->num_rows > 0 ? 'Taken' : 'Pending' ?></td>
						<td>
							<center>
							 	<?php if($status->num_rows <= 0): ?>
							 	<a class="btn btn-sm btn-outline-primary" href="./exam_sheet.php?id=<?php echo $row['id']?>"><i class="fa fa-pencil"></i> Take Exam</a>
								<?php else: ?>
								<a class="btn btn-sm btn-outline-primary" href="./view_answer.php?id=<?php echo $row['id']?>"><i class="fa fa-eye"></i> View</a>
							<?php endif; ?>
							</center>
						</td>
					</tr>
					<?php
					}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_teacher').click(function(){
			$('#msg').html('')
			$('#manage_teacher .modal-title').html('Add New teacher')
			$('#manage_teacher #teacher-frm').get(0).reset()
			$('#manage_teacher').modal('show')
		})
		$('.edit_teacher').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_teacher.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.id)
						$('[name="uid"]').val(resp.uid)
						$('[name="name"]').val(resp.name)
						$('[name="subject"]').val(resp.subject)
						$('[name="username"]').val(resp.username)
						$('[name="password"]').val(resp.password)
						$('#manage_teacher .modal-title').html('Edit teacher')
						$('#manage_teacher').modal('show')

					}
				}
			})

		})
		$('.remove_teacher').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_teacher.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('#teacher-frm').submit(function(e){
			e.preventDefault();
			$('#teacher-frm [name="submit"]').attr('disabled',true)
			$('#teacher-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./save_teacher.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#teacher-frm [name="submit"]').removeAttr('disabled')
					$('#teacher-frm [name="submit"]').html('Save')
				},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							alert('Data successfully saved');
							location.reload()
						}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

						}
					}
				}
			})
		})
	})
</script>
</html>