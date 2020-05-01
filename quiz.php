<?php
	session_start();
	$userID = $_SESSION['userID'];
	if(!$userID)
	{
		header("location:courses.php");
	}
	else
	{
	//session_start();
	extract($_GET);
	$_SESSION['start_time'] = time();
	include './connection/connection.php';
	// $quizID = $_GET['quizID'];
	// $courseID = $_GET['courseID'];
	// $quizType = $_GET['quizType'];
	$quizSQL = "SELECT * FROM `learning_questions` WHERE quiz_ID=$quizID ORDER BY `learning_questions`.`ID` ASC";
	$result = mysqli_query($con,$quizSQL);

	// getting quiz details ↓↓
	$detailsQuery = "SELECT a.lesson_title,b.quiz_title FROM learning_lessons a, learning_quiz b WHERE a.ID = b.lesson_ID AND b.quiz_type='$quizType'";
	$detailsRes = mysqli_query($con,$detailsQuery) or die(mysqli_error($con));
	$detailsRow = mysqli_fetch_row($detailsRes);

	//getting Lessons List
	$getLessonsQuery = "SELECT * FROM `learning_lessons` WHERE course_ID = $courseID ORDER BY `ID` ASC";
	$lessonsResult = mysqli_query($con,$getLessonsQuery) or die(mysqli_error($con));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/vs_quiz_style.css">
</head>
	<body bgcolor="lightyellow">
		<div class="vs_quizContainer" id="vs_quizContainer">
			<div class="vs_quiz"> <!-- quiz container width 70% -->
				<div class="vs_quizTitleDiv">
					<span class="vs_quizTitle"><?=$detailsRow[1]?></span>
				</div>
				<form action="validateQuiz.php?quizID=<?=$quizID?>" method="post" name="optionFrm">
				<?php
						$i=1;
					foreach ($result as $key => $value) 
					{
					
				?>
				
				<div class="vs_questionDiv">
					<div class="vs_lessonTitleDiv">
						<span class="vs_lessonTitle"><?=$detailsRow[0]?></span>
					</div>
					<div class="vs_quizSection">
						
						<div class="vs_questionSection" name="quizQuestion">
							<div class="vs_imageSection">
								<img src="./images/<?=$value['img']?>" class="vs_image" >
							</div>

							<div class="vs_question">
								<div class="vs_eng">
									<div style="margin-top: 10%;">
											<span class="vs_engQiestion">English</span>
											<div class="vs_eng_qDiv">
												<span><?=$value['question']?></span>
											</div>
									</div>
								</div>
								<div class="vs_ned">
									<div style="margin-top: 10%;">
											<span class="vs_nedQiestion">Nederlands</span>
											<div class="vs_ned_qDiv">
												...?
											</div>
									</div>
								</div>
							</div>
							<div class="vs_optionSection">
								<div class="vs_options">
									
										<table class="vs_optionTbl">
											<tr><td style="border-bottom:none; border-top:none"><input type="radio" name="ans<?=$i?>" value="1" class="vs_radio" required><?=$value['opt1']?></td></tr>
											<tr><td style="border-bottom:none; border-top:none"><input type="radio" name="ans<?=$i?>" value="2" class="vs_radio"><?=$value['opt2']?></td></tr>
											<tr><td style="border-bottom:none; border-top:none"><input type="radio" name="ans<?=$i?>" value="3" class="vs_radio"><?=$value['opt3']?></td></tr>
											<tr><td style="border-bottom:none; border-top:none"><input type="radio" name="ans<?=$i?>" value="4" class="vs_radio"><?=$value['opt4']?></td></tr>
										</table>
									<!-- <input type="text" name="sample<?=$i?>" value="sample count" /> -->
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
					$i++;
					}
				?>
				<div>
					<a href="lesson.php?lessonID=<?=$lessonID?>&courseID=<?=$courseID?>" class="vs_backBtn">Go to lesson</a>
					<input type="reset" name="reset" class="btnReset" />
					<input type="submit" name="submit" value="Submit Quiz" class="btnSubmit" />			
				</div>
				</form>
			</div>
		</div>
		<!-- <div class="vs_lessonContainer">
			<div class="vs_lesson">
				<table class="vs_lesson_table">
					<tr class="vs_lessonHead">
						<th>Lessons</th>
					</tr>
					<?php
						foreach ($lessonsResult as $key => $value) {
					?>
					<tr class="vs_lessonsList">
						<td><a href="lesson.php?lessonID=<?=$value['ID']?>&courseID=<?=$courseID?>" class="vs_lessonItem"><?=$value['lesson_title']?></a></td>
					</tr>
					<?php
					}
					?>
				</table>

			</div>
		</div> -->
	</body>
</html>
<?php
	}
?>