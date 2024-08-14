<!DOCTYPE html>
<html lang="en">
<head>
	</head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<title>Exam List</title>
</head>
<body style="display:flex">
	<div>
	<?php include('nav_bar.php') ?>
	</div>
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary">Exam List</div>
		<button class="btn btn-primary bt-sm" id="new_exam"><i class="fa fa-plus"></i>	Add New</button>
		<br>
		<br>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered" id='table'>
					
					<thead>
						<tr>
							<th>#</th>
							<th>Subject</th>
							<th>Items</th>
							<th>Point per Items</th>
							<?php if($_SESSION['login_user_type'] ==1): ?>
							<th>Teacher</th>
							<?php endif; ?>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$where = '';
					if($_SESSION['login_user_type'] == 2){
						$where = " where u.id = ".$_SESSION['login_id']." ";
					}
					$qry = $conn->query("SELECT e.*,u.name as fname from exam_list e left join users u on e.user_id = u.id ".$where." order by e.title asc ");
					$i = 1;
					if($qry->num_rows > 0){
						while($row= $qry->fetch_assoc()){
							$items = $conn->query("SELECT count(id) as item_count from questions where eid = '".$row['id']."' ")->fetch_array()['item_count'];
						?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['title'] ?></td>
						<td><?php echo $items ?></td>
						<td><?php echo $row['qpoints'] ?></td>
							<?php if($_SESSION['login_id'] ==1): ?>
						<td><?php echo $row['fname'] ?></td>
							<?php endif; ?>
						<td>
							<center>
							 <a class="btn btn-sm btn-outline-primary edit_exam" href="./exam_view.php?id=<?php echo $row['id']?>"><i class="fa fa-task"></i> Manage</a>
							 <button class="btn btn-sm btn-outline-primary edit_exam" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i> Edit</button>
							<button class="btn btn-sm btn-outline-danger remove_exam" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i> Delete</button>
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
	<div class="modal fade" id="manage_exam" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New Exam</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='exam-frm'>
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Subject</label>
									<input type="hidden" name="id" />
									<input type="text" name="title" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Points per question</label>
									<input type="nember" name ="qpoints" required="" class="form-control" />
								</div>
								<?php if($_SESSION['login_user_type'] == 1): ?>
								<div class="form-group">
									<label>Teacher</label>
									<select name="user_id" required="required" class="form-control" />
									<option value="" selected="" disabled="">Select Here</option>
									<?php
										$qry = $conn->query("SELECT * from users where user_type = 2 order by name asc");
										while($row= $qry->fetch_assoc()){
									?>
										<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php } ?>
									</select>
								</div>
								<?php else: ?>
									<input type="hidden" name="user_id" />
								<?php endif; ?>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
</body>
<script>
	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_exam').click(function(){
			$('#msg').html('')
			$('#manage_exam .modal-title').html('Add New Exam')
			$('#manage_exam #exam-frm').get(0).reset()
			$('#manage_exam').modal('show')
		})
		$('.edit_exam').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_exam.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.id)
						$('[name="title"]').val(resp.title)
						$('[name="qpoints"]').val(resp.qpoints)
						$('[name="user_id"] ').val(resp.user_id)
						$('#manage_exam .modal-title').html('Edit Exam')
						$('#manage_exam').modal('show')

					}
				}
			})

		})
		$('.remove_exam').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_exam.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					location.reload()
				}
			})
			}
		})
		$('#exam-frm').submit(function(e){
			e.preventDefault();
			$('#exam-frm [name="submit"]').attr('disabled',true)
			$('#exam-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./save_exam.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#exam-frm [name="submit"]').removeAttr('disabled')
					$('#exam-frm [name="submit"]').html('Save')
				},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							alert('Data successfully saved');
							location.replace('./exam_view.php?id='+resp.id)
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