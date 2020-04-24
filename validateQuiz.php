<?php
extract($_POST);
extract($_GET);
session_start();
$difference = 0;
if (is_int($_SESSION['start_time'])){ // if the cookie exists:
    $difference = time() - $_SESSION['start_time'];
} else { // if the cookie does not exist:
    echo "You have been here some time in the future";
}
include './connection/connection.php';
$questionQuery = "SELECT * FROM `learning_questions` WHERE quiz_id=$quizID ORDER BY `ID` ASC";
$result = mysqli_query($con,$questionQuery) or die(mysqli_error($con));
$total = mysqli_num_rows($result);

$i=1;
$correct=0;
$wrong=0;
$score=0;
foreach ($result as $key => $value)
{
	if($_POST['ans'.$i] == $value['ans'])
	{
		// echo $_POST['ans'.$i]." = ".$value['ans']."<br>";
		$correct+=1;
	}
	else
	{
		$wrong+=1;
	}
	$i++;
}
$score = round(($correct/$total)*100,2);
$time = gmdate("i:s", $difference);

// session_destroy();
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/vs_style.css">
	<title>Result</title>
</head>
<body>
	<div class="vs_resContainer">
		<h2 align="center">Results...</h2>
		<div class="vs_resultDiv">
			<table class="vs_resTable"> 
				<tr class="vs_rowItems">
					<th>Total Questions</th>
					<th>Correct Answers</th>
					<th>Wrong Answers</th>
					<th>Result</th>
					<th>Time Taken</th>
				</tr>
				<tr class="vs_rowItems">
					<td><?=$total?></td>
					<td><?=$correct?></td>
					<td><?=$wrong?></td>
					<td><?=$score?></td>
					<td><?=$time?></td>
				</tr>
			</table>
		</div>
		<span class="vs_resMsg">You Have Reached <?=$correct?> of <?=$total?> points, (<?=$score?>%)</span>
		<div>
			<button onclick="myFunction()" class="vs_reviewBtn">Review Answers</button>
			<a href="courses.php" class="vs_homeBtn">Go to Main Page</a>
		</div>
		<div class="vs_myDIV" id="vs_myDIV">
			<?php
			$j=1;
			foreach ($result as $key => $value) 
			{
				// echo "<table class=vs_review_tbl>";
				// echo "<tr><th class=vs_qNo><span>Question $j </th><th class=vs_q> $value[question] </span></th>";
				if($_POST['ans'.$j] == $value['ans'])
				{
					$ansColor = "green";
					
				}
				else
				{
					$ansColor = "red";
				}
				// echo "</table>";
				// $j++;
			//}
			?>
			<div class="vs_questionSection" name="quizQuestion">
				<div class="vs_imageSection">
					<img src="./images/<?=$value['img']?>" class="vs_image">
				</div>

				<div class="vs_question">
					<div class="vs_eng">
						<div style="margin-top: 10%;">
								<span class="vs_engRev">English</span>
								<div class="vs_eng_qDiv">
									<span><?=$value['question']?></span>
								</div>
						</div>
					</div>
					<div class="vs_ned">
						<div style="margin-top: 10%;">
								<span class="vs_nedRev">Nederlands</span>
								<div class="vs_ned_qDiv">
									...?
								</div>
						</div>
					</div>
				</div>
				<div class="vs_optionSection">
					<div class="vs_options">
						
							<table class="vs_optionTbl">
								<?php if($value['ans'] == 1){ ?>
								<tr><td class="vs_correct"><?=$value['opt1']?></td></tr>
							
								<tr><td><?=$value['opt2']?></td></tr>
								<tr><td><?=$value['opt3']?></td></tr>
								<tr><td><?=$value['opt4']?></td></tr>
								<tr><td>Your Choice : <span style="color: <?=$ansColor?> "><?=$value['opt'.$ans1]?></span></td></tr>
								<?php } ?>

								<?php if($value['ans'] == 2){ ?>
								<tr><td><?=$value['opt1']?></td></tr>
								<tr><td class="vs_correct"><?=$value['opt2']?></td></tr>
								<tr><td><?=$value['opt3']?></td></tr>
								<tr><td><?=$value['opt4']?></td></tr>
								<tr><td>Your Choice : <span style="color: <?=$ansColor?> "><?=$value['opt'.$ans2]?></span></td></tr>
								<?php } ?>

								<?php if($value['ans'] == 3){ ?>
								<tr><td><?=$value['opt1']?></td></tr>
								<tr><td><?=$value['opt2']?></td></tr>
								<tr><td class="vs_correct"><?=$value['opt3']?></td></tr>
								<tr><td><?=$value['opt4']?></td></tr>
								<tr><td>Your Choice : <span style="color: <?=$ansColor?> "><?=$value['opt'.$ans3]?></span></td></tr>
								<?php } ?>

								<?php if($value['ans'] == 4){ ?>
								<tr><td><?=$value['opt1']?></td></tr>
								<tr><td><?=$value['opt2']?></td></tr>
								<tr><td><?=$value['opt3']?></td></tr>
								<tr><td class="vs_correct"><?=$value['opt4']?></td></tr>
								<tr><td>Your Choice : <span style="color: <?=$ansColor?> "><?=$value['opt'.$ans4]?></td></tr>
								<?php } ?>
							</table>
						<!-- <input type="text" name="sample<?=$i?>" value="sample count" /> -->
					</div>
				</div>
			</div>	
			<hr>
		<?php $j++; } ?>
		</div>
	</div>
</body>
<script>
function myFunction() {
  var x = document.getElementById("vs_myDIV");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
</html>
