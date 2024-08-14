<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<?php 
		$title = "";
		$exam = null;
		$exam_id = null;
		if (isset($_GET['id'])) {
			$exam_id = $_GET['id'];
			$exam = $conn->query("SELECT * FROM exam_list WHERE id = " . $exam_id)->fetch_array();
			$title = $exam["title"];
		} else {
			echo "No quiz ID provided.";
		}
	?>
	<title><?php echo $exam['title'] ?> | Exam Sheet</title>
</head>
<body style="display:flex">
	<div>
	<?php include('nav_bar.php') ?>
	</div>
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary"><?php echo $title ?></div>
		<br>
		<div id="timer"></div>
		
		<div class="card" style="margin-bottom: 20px;">
			<div class="card-body">
				<form action="" id="exam-sheet">
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'] ?>">
					<?php
					$questionQuery = $conn->query("SELECT * FROM questions WHERE eid = '".$exam_id."' ");
					$i = 0; 
					$totalQuestions = $questionQuery->num_rows;

					while($questions = $questionQuery->fetch_assoc()) {
						$questionId = $questions['id'];
						$options = array(
							$questions['option1'],
							$questions['option2'],
							$questions['option3'],
							$questions['option4']
						);
					?>
					
					<ul class="q-items list-group mt-4 mb-4" id="question-<?php echo $i ?>">
						<li class="q-field list-group-item">
							<strong><span></span><?php echo ($i + 1). ') '; ?> <?php echo $questions['question'] ?></span></strong>
							<br>
							<br>
							<?php if (!empty($questions['image_url'])): ?>
								<img src="<?php echo $questions['image_url']; ?>" alt="Question Image" style="max-width: 100%; height: auto;">
							<?php endif; ?>
							<ul class='list-group mt-4 mb-4'>
								<?php 
								$optionCounter = 0;
								$optionAlphabets = ['A', 'B', 'C', 'D'];
								foreach ($options as $option) {
									$alphabet = $optionAlphabets[$optionCounter++];
									$optionValue= $optionCounter;
								?>
								<li class="answer list-group-item">
									<label><input type="radio" name="option_id[<?php echo $questionId ?>]" value="<?php echo $optionValue ?>"> <?php echo $alphabet . '. ' . $option ?></label>
								</li>
								<?php } ?>
							</ul>
							<?php if ($i > 0): ?>
								<button class="btn btn-primary prev-btn">Previous</button>
							<?php endif; ?>
							<?php if ($i < $totalQuestions - 1): ?>
								<button class="btn btn-primary next-btn">Next</button>
							<?php endif; ?>
							<?php if ($i == $totalQuestions - 1): ?>
								<button class="btn btn-primary submit-btn">Submit</button>
							<?php endif; ?>
						</li>
					</ul>
					<?php $i++; } ?>
				</form>
				<div style=" display:flex; flex-wrap:wrap; padding:50px" class="question-nav">
					<?php for ($j = 1; $j <= $totalQuestions; $j++): ?>
						<button class="btn btn-secondary m-2 question-nav-btn"  data-question="<?php echo $j - 1; ?>"><?php echo $j; ?></button>
					<?php endfor; ?>
				</div>
			</div>	
		</div>
	</div>
</body>
<script>

	$(document).ready(function() { 
		var timer; 
		var remainingTime = 30 * 60; 

		function updateTimer() {
			var minutes = Math.floor(remainingTime / 60);
			var seconds = remainingTime % 60;
			$('#timer').text('Time Remaining: ' + minutes + ':' + seconds );

			if (remainingTime <= 0) {
				clearInterval(timer);
				$('#exam-sheet').submit(); 
			}
			remainingTime--;
		}

		timer = setInterval(updateTimer, 1000);

		var currentQuestion = 0; 
		var totalQuestions = <?php echo $totalQuestions ?>;
		
		function showQuestion() {
			$('.q-items').hide();
			$('#question-' + currentQuestion).show();
		}

		function goToNextQuestion() {
			if (currentQuestion < totalQuestions - 1) {
				currentQuestion++;
				showQuestion();
			}
		}

		function goToPreviousQuestion() {
			if (currentQuestion > 0) {
				currentQuestion--;
				showQuestion();
			}
		}
		showQuestion();

		$('.next-btn').click(function(e) {
			e.preventDefault();
			goToNextQuestion();
		});
		$('.prev-btn').click(function(e) {
			e.preventDefault();
			goToPreviousQuestion();
		});
		$('.question-nav-btn').click(function(e) {
			e.preventDefault();
			var questionNumber = $(this).data('question');
			showQuestionByNumber(questionNumber);
		});

		function showQuestionByNumber(questionNumber) {
			$('.q-items').hide();
			$('#question-' + questionNumber).show();
			currentQuestion = questionNumber; 
		}



	$('input[type="radio"]').on('click', function() {
    var questionId = $(this).closest('.q-items').attr('id').split('-')[1];
    var answerValue = $(this).val();
    saveAnswer(questionId, answerValue);
   });
   function saveAnswer(questionId, answerValue) {
    var savedAnswers = localStorage.getItem('examAnswers');
    var answers = savedAnswers ? JSON.parse(savedAnswers) : {};
    answers[questionId] = answerValue;
    localStorage.setItem('examAnswers', JSON.stringify(answers));
}

var savedAnswers = localStorage.getItem('examAnswers');
   if (savedAnswers) {
	 alert(savedAnswers)
        var answers = JSON.parse(savedAnswers);
        $.each(answers, function(questionId, answerValue) {
            var selector = "input[name='option_id[" + questionId + "]'][value='" + answerValue + "']";
			 $(selector).prop('checked', true);

        });
    }

    function submitAnswers() {
    var examId = <?php echo $exam_id ?>; 
    var formData = $('#exam-sheet').serialize(); 
	console.log(examId); 
    console.log(formData); 
    $.ajax({
        url: 'submit_answer.php',
        method: 'POST',
        data: {
            exam_id: examId,
            formData: formData 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to submit answers. Please try again.');
        },
        success: function(response) {
			alert("your answer is saved!")
			 localStorage.removeItem('examAnswers');

			window.location.replace("student_exam_list.php");


    }
    });
}

$('.submit-btn').click(function(e) {
    e.preventDefault();
    clearInterval(timer);
    submitAnswers();
 });

	});
</script>
</html>
