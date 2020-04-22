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
	<link rel="stylesheet" type="text/css" href="./css/lessonsStyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<form method="post">
	<div class="lessonsContainer">
		<div class="lessonsHeading" >
			<h2><?=$course?></h2>
			<h5>Course Status:</h5>
			<h4>Course Contents</h4>
		</div>

		<div class="lessonsListContainer">
			<table class="coursetbl">
				<tr class="tblHead">
					<th colspan="2" >Lessions</th>
					<th class="checkST">Status</th>
				</tr>
				<?php 
					$i=1;
					foreach ($result as $key => $value)
					{
					
				?>
				<tr class="tblData">
					<td class="slno"><?=$i?></td>
					<td><a href="lesson.php?lessonID=<?=$value['ID']?>" class="lessonsTitle" title="<?=$value['lesson_title']?>"><?=$value['lesson_title']?></a>
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
