<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<?php 
	$exam_id = $_GET['id'];
	$exam = $conn->query("SELECT * FROM exam_list where id =".$exam_id)->fetch_array();
	$hist = $conn->query("SELECT * FROM history where exam_id =".$exam_id." and user_id = ".$_SESSION['login_id'])->fetch_array();
	?>
	<title><?php echo $exam['title'] ?> | Answer Sheet</title>
</head>
<body style="display:flex">
	<style>
		li.answer input:checked{
			background: #00c4ff3d;
		}
	</style>
	<div>
	<?php include('nav_bar.php') ?>

	</div>
	
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary"><?php echo $exam['title'] ?> | <?php echo $exam['qpoints'] .' Points Each Question' ?></div>
		<div class="col-md-12 alert alert-success">SCORE : <?php echo $hist['score'] .' / ' .  $hist['total_score'] ?></div>
		<br>
		<div class="card">
			<div class="card-body">
				<form id="exam-sheet">
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'] ?>">
					<input type="hidden" name="quiz_id" value="<?php echo $quiz_id ?>">
					<input type="hidden" name="qpoints" value="<?php echo $quiz['qpoints'] ?>">
					<?php
					$question_query = $conn->query("SELECT * FROM questions WHERE eid = '".$exam_id."' ");
					$i = 1 ;
					while($row = $question_query->fetch_assoc()){
						$correct_answer = $row['correct_answer'];
					?>
						<ul class="q-items list-group mt-4 mb-4">
							<li class="q-field list-group-item">
								<strong><?php echo $i++. '. ' . $row['question'] ?></strong>
								<br>
								<br>
								<?php if (!empty($row['image_url'])): ?>
                                 <img src="<?php echo $row['image_url']; ?>" alt="Question Image" style="max-width: 100%; height: auto;">
                                <?php endif; ?>
								<ul class='list-group mt-4 mb-4'>
									<?php 
									$optionLetters = ['A', 'B', 'C', 'D'];
									foreach ($optionLetters as $index => $alphabet) {
										$option_column = 'option' . ($index + 1);
										$option_text = $row[$option_column];
										$is_correct = $index + 1 == $correct_answer ? "bg-success" : "";
									?>
										<li class="answer list-group-item <?php echo $is_correct ?>">
												<?php echo $alphabet . '. ' . $option_text ?>
										</li>
									<?php
									}
									?>
								</ul>
							</li>
						</ul>
					<?php } ?>
				</form>
			</div>	
		</div>
	</div>
</body>

</html>
