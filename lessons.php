<?php
	include './connection/connection.php';
	if($con)
	{
		$course = $_GET['course'];
		$courseID = $_GET['courseID'];
		$sql = "SELECT * FROM `learning_lessons` WHERE course_ID = $courseID ORDER BY `learning_lessons`.`ID` ASC";
		$result = mysqli_query($con,$sql) or die("Failed To Fetch Course Data");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$course?></title>
	<link rel="stylesheet" type="text/css" href="./css/vs_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<form method="post">
	<div class="vs_lessonsContainer">
		<div>
			<h2><?=$course?></h2>
			<h5>Course Status:</h5>
			<h4>Course Contents</h4>
		</div>

		<div class="vs_lessonsListContainer">
			<table class="vs_table">
				<tr class="vs_tblHead">
					<th colspan="2" >Lessions</th>
					<th class="vs_checkST">Status</th>
				</tr>
				<?php 
					$i=1;
					foreach ($result as $key => $value)
					{
					
				?>
				<tr class="vs_data">
					<td class="vs_slno"><?=$i?></td>
					<td><a href="lesson.php?lessonID=<?=$value['ID']?>" class="vs_lessonsTitle" title="<?=$value['lesson_title']?>"><?=$value['lesson_title']?></a>
					<td class="checkST"><span class="fa fa-check-square" style="font-size: 25px;" aria-hidden='true'></span></td>
				</tr>
				<?php
				$i++;
					}
				?>

			</table>
		</div>
	</div>
	</form>
</body>
</html>
