<?php
	session_start();
	$userID = $_SESSION['userID'];
	if(!$userID)
	{
		header("location:courses.php");
	}
	else
	{
	include './connection/connection.php';
	if($con)
	{
		$lessonID = $_GET['lessonID'];
		$courseID = $_GET['courseID'];
		$sql = "SELECT * FROM `learning_lessons` WHERE ID=$lessonID";
		$result = mysqli_query($con,$sql) or die("Failed To Fetch Lesson Data");
		$row = mysqli_fetch_array($result);
		$url=$row[3];
		
		$vocSQL = "SELECT * FROM `learning_vocab` WHERE lesson_ID=$lessonID ORDER BY `learning_vocab`.`ID` ASC";
		$vocResult = mysqli_query($con,$vocSQL) or die("Failed To Fetch Vocabulary Data");

		$quizSQL = "SELECT * FROM `learning_quiz` WHERE lesson_ID=$lessonID ORDER BY `learning_quiz`.`ID` ASC";
		$quizRes = mysqli_query($con,$quizSQL) or die("Failed To Fetch Quiz Data");
	}
		$checkLockedQuery = "SELECT * FROM `user_quiz` WHERE module_ID = $lessonID AND user_ID = $userID AND module = 'lesson'";
		$checkLockedResult = mysqli_query($con,$checkLockedQuery) or die($con);
		if(!(mysqli_num_rows($checkLockedResult)))
		{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Lesson Locked!!!</title>
	</head>
	<body>
		<center>
			<h1>This Lesson is Locked... Complete the Previous Lesson First...</h1>
		</center>
	</body>
	</html>
	<?php
		}
		else
		{	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$row[2]?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/vs_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="vs_lesson_container">
		<h2><?=$row[2]?></h2>
		<!-- If Video Link is not available then do not show this video section -->
		<?php
		 if($row[3])
		 {
		?>
		<div class="vs_video">
			<iframe class="vs_iframe" src="<?=$row[3]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<?php
			}
		?>
		<!-- Up to Here -->
		<div class="vs_descDiv">
			<span class="vs_desc"><?=ucwords($row[4])?></span>
		</div>
		<div class="vs_vocDiv">
			<div class="vs_vocTitle">
				<span>Vocabulary List</span>
			</div>
			<table class="vs_table">
				<tr class="vs_tblHead">
					<th>English</th>
					<th>Netherlands</th>
				</tr>
				<?php
					foreach ($vocResult as $key => $value) {
				?>
				<tr class="vs_data">
					<td><?=$value['eng_word']?></td>
					<td><?=$value['ned_word']?></td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>

		<div class="vs_vocDiv">
			<div class="vs_vocTitle">
				<span>Exercise</span>
			</div>
			<table class="vs_table">
				<tr class="vs_tblHead">
					<th colspan="2">Quizzes</th>
					<th class="vs_check">status</th>
				</tr>
				<?php
					$i=1;
					foreach ($quizRes as $key => $value) {
				?>
				<tr class="vs_data">
					<td class="vs_slno"><?=$i?></td>
					<td><a class="vs_title" href="quiz.php?quizID=<?=$value['ID']?>&quizType=<?=$value['quiz_type']?>&courseID=<?=$courseID?>&lessonID=<?=$lessonID?>"><?=$value['quiz_title']?></a></td>
					<td class="vs_checkST"><span class="fa fa-check-square" style="font-size: 25px;" aria-hidden='true'></span></td>
				</tr>
				<?php
				$i++;
					}
				?>
			</table>
		</div>
		<div class="lessonNavigate">
			<a href="#" style="text-decoration: none;"><span>Next Lesson →</span></a>
		</div>
	</div>
</body>
</html>
<?php
	}
	} //end of session
?>