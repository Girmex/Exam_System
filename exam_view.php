<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<title>Exam List</title>
	<?php 
	$qry = $conn->query("SELECT * FROM exam_list where id = ".$_GET['id'])->fetch_array();
	?>
</head>
<body style="display:flex">
	<div>
	<?php include('nav_bar.php') ?>
	</div>
	
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary"><?php echo $qry['title'] ?></div>
		
		<button class="btn btn-primary bt-sm" id="new_question"><i class="fa fa-plus"></i>	Add Question</button>
		<button class="btn btn-primary bt-sm" id="new_student"><i class="fa fa-plus"></i>	Add Student</button>
		<div class="card col-md-6 mr-4" style="float:left">
		<form action="import_csv.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="exam_id" value="<?php echo $_GET['id']; ?>">
            <input type="file" name="csv_file" accept=".csv">
            <button class="btn btn-primary bt-md" type="submit" name="submit"><i class="fa fa-upload"></i>Import</button>
        </form>
			<div class="card-header">
				Questions
			</div>
			<div class="card-body">
    <table class="table" id="questions">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
				$eid = $_GET['id'];
				$qry = $conn->query("SELECT * FROM questions WHERE eid = '".$eid."' ");             
			    $count = 1; 
                while($row=$qry->fetch_array()){
            ?>
            <tr>
                <td><?php echo $count++; ?></td> 
                <td><?php echo $row['question'] ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary edit_question" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger remove_question" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>

	</div>
	<div class="card col-md-5" style="float:left">
			<div class="card-header">
				Students
			</div>
			<div class="card-body">
				<ul class="list-group">
				<?php
					$qry = $conn->query("SELECT u.*,e.id as eid FROM users u left join exam_student_list e on u.id = e.user_id where e.exam_id = ".$_GET['id']." order by u.name asc");
					while($row=$qry->fetch_array()){
						?>
						<li class="list-group-item"><?php echo ucwords($row['name']) ?>
								<button class="btn btn-sm btn-outline-danger remove_student pull-right" data-id="<?php echo $row['id']?>" data-eid='<?php echo $row['eid'] ?>' type="button"><i class="fa fa-trash"></i></button>
						</li>
				<?php
					}
				?>
				</ul>
		</div>
	</div>
	<div class="modal fade" id="manage_question" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New Question</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='question-frm'>
						<div>
							<button type="button" class="symbol-button" onclick="insertSymbol('∫')">∫</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('√')">√</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('∑')">∑</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('π')">π</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('θ')">θ</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('Δ')">Δ</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('γ')">γ</button>
							<button type="button" class="symbol-button" onclick="insertSymbol('∞')">∞</button>
							<button type="button" class="symbol-button" onclick="insertSuperscript()">Sup</button>
							<button type="button" class="symbol-button" onclick="insertSubscript()">Sub</button>
						</div>
						<div class ="modal-body">
								<div id="msg"></div>
								<div style="display:flex; justify-content:center"><span >F(X): &nbsp</span>
								<textarea rows='1' name="formula"  class="form-control" placeholder="write formaulas here and copy"></textarea>

								</div>
								<div class="form-group">
									<label>Question</label>
									<input type="hidden" name="qid" value="<?php echo $_GET['id'] ?>" />
									<input type="hidden" name="id" />
									<textarea rows='3' name="question"  class="form-control" ></textarea>
								</div>
								   <div class="form-group">
									<label>Image</label>
									<input type="file" name="image" class="form-control-file">
								</div>
								<div class="form-group">
											<label>Option 1</label>
											<textarea name="option1" class="form-control"></textarea>
											<label>Option 2</label>
											<textarea name="option2" class="form-control"></textarea>
											<label>Option 3</label>
											<textarea name="option3" class="form-control"></textarea>
											<label>Option 4</label>
											<textarea name="option4" class="form-control"></textarea>
											<label>Correct Answer</label>
											<select name="correct_answer" class="form-control">
												<option value="1">Option 1</option>
												<option value="2">Option 2</option>
												<option value="3">Option 3</option>
												<option value="4">Option 4</option>
											</select>
									</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="manage_student" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered " role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New Student/s</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='student-frm'>
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Student/s</label>
									<br>
									<input type="hidden" name="eid" value="<?php echo $_GET['id'] ?>" />
									<select rows='3' name="user_id[]" required="required" multiple class="form-control select2" style="width: 100% !important">
									<?php 
									$student = $conn->query('SELECT u.*,s.grade_section as ls FROM users u left join students s on u.id = s.user_id where u.user_type = 3 ');
									while($row=$student->fetch_assoc()){

									?>	
									<option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['name']).' '.$row['ls'] ?></option>
								<?php } ?>
								</select>

									</select>
								</div>
								
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<script src="./symbols.js"></script>

<script>
	$(document).ready(function(){

	
		$(".select2").select2({
			placeholder:"Select here",
			width:'resolve'
		});
		$('#table').DataTable();
		$('#new_question').click(function(){
		     
			$('#msg').html('')
			$('#manage_question .modal-title').html('Add New Question')
			$('#manage_question #question-frm').get(0).reset()
			
			$('#manage_question').modal('show')
		})
		$('#new_student').click(function(){
			$('#msg').html('')
			$('#manage_student').modal('show')
		})

	

	var table = $('#questions').DataTable({  deferRender: true });

    table.on('draw.dt', function() {
		$('.edit_question').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url:'./get_question.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						console.log(resp.qdata)
						$('[name="id"]').val(resp.qdata.id)
						$('[name="question"]').val(resp.qdata.question)
						$('[name="image"]').val(resp.qdata.image_url)
						$('[name="option1"]').val(resp.qdata.option1)
						$('[name="option2"]').val(resp.qdata.option2)
						$('[name="option3"]').val(resp.qdata.option3)
						$('[name="option4"]').val(resp.qdata.option4)
						$('[name="correct_answer"]').val(resp.qdata.correct_answer)

						$('#manage_question .modal-title').html('Edit Question')
						$('#manage_question').modal('show')

					}
				}
			})

		})

		$('.remove_question').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_question.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
    });


	
		$('.remove_student').click(function(){
			var eid = $(this).attr('data-eid');
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
					url: './delete_exam_student.php?eid=' + eid,
					error: err => console.log(err),
					success: function(resp){
							location.reload();
						
					}
				});
		}
});

		$('#question-frm').submit(function(e){
			e.preventDefault();
			$('#question-frm [name="submit"]').attr('disabled',true)
			$('#question-frm [name="submit"]').html('Saving...')
			$('#msg').html('')
			var formData = new FormData(this);
			$.ajax({
				url:'./save_question.php',
				method:'POST',
				data: formData,
			   processData: false, 
               contentType: false,
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#quiz-frm [name="submit"]').removeAttr('disabled')
					$('#quiz-frm [name="submit"]').html('Save')
				},
				success:function(response){
					alert("successfulty added!")
					location.reload()
						
				}
			})
		})
		$('#student-frm').submit(function(e){
			e.preventDefault();
			$('#student-frm [name="submit"]').attr('disabled',true)
			$('#student-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./exam_student.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#quiz-frm [name="submit"]').removeAttr('disabled')
					$('#quiz-frm [name="submit"]').html('Save')
				},
				success:function(response){
						if(response == 1){
							alert('Data successfully saved');
							location.reload()
						}
				}
			})
		})
	})
</script>
</body>
</html>