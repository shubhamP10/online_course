<?php
	include './connection/connection.php';
	if($con)
	{
		$lessonID = $_GET['lessonID'];
		$sql = "SELECT * FROM `learning_lessons` WHERE ID=$lessonID";
		$result = mysqli_query($con,$sql) or die("Failed To Fetch Lesson Data");
		$row = mysqli_fetch_array($result);
		$url=$row[3];
		
		$vocSQL = "SELECT * FROM `learning_vocab` WHERE lesson_ID=$lessonID ORDER BY `learning_vocab`.`ID` ASC";
		$vocResult = mysqli_query($con,$vocSQL) or die("Failed To Fetch Vocabulary Data");

		$quizSQL = "SELECT * FROM `learning_quiz` WHERE lesson_ID=$lessonID ORDER BY `learning_quiz`.`ID` ASC";
		$quizRes = mysqli_query($con,$quizSQL) or die("Failed To Fetch Quiz Data");
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$row[2]?></title>
	<link rel="stylesheet" type="text/css" href="./css/lessonStyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="lessonContainer">
		<h2><?=$row[2]?></h2>
		<!-- If Video Link is not available then do not show this video section -->
		<?php
		 if($row[3])
		 {
		?>
		<div class="lessonVideo">
			<iframe class="lessonIframe" src="<?=$row[3]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<?php
			}
		?>
		<!-- Up to Here -->
		<div class="descDiv">
			<span class="desc"><?=ucwords($row[4])?></span>
		</div>
		<div class="vocDiv">
			<div class="vocTitle">
				<span>Vocabulary List</span>
			</div>
			<table>
				<tr class="tblHead">
					<th>English</th>
					<th>Netherlands</th>
				</tr>
				<?php
					foreach ($vocResult as $key => $value) {
				?>
				<tr class="lessonData">
					<td><?=$value['eng_word']?></td>
					<td><?=$value['ned_word']?></td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>

		<div class="vocDiv">
			<div class="vocTitle">
				<span>Exercise</span>
			</div>
			<table>
				<tr class="tblHead">
					<th colspan="2">Quizzes</th>
					<th class="check">status</th>
				</tr>
				<?php
					$i=1;
					foreach ($quizRes as $key => $value) {
				?>
				<tr class="lessonData">
					<td class="slno"><?=$i?></td>
					<td><a class="lessonTitle" href="quiz.php?quizID=<?=$value['ID']?>"><?=$value['quiz_title']?></a></td>
					<td class="checkST"><span class="fa fa-check-square" style="font-size: 25px;" aria-hidden='true'></span></td>
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