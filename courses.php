<?php
	include './connection/connection.php';
	if($con)
	{
		$sql = "SELECT * FROM `learning_courses` ORDER BY `learning_courses`.`ID` ASC";
		$result = mysqli_query($con,$sql) or die("Failed To Fetch Course Data");

	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Courses</title>
	<link rel="stylesheet" type="text/css" href="./css/vs_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="vs_courseContainer">
		<div class="vs_courseHeading">
			<h2>All Courses</h2>
		</div>
		<div class="vs_courseListContainer">
			<table class="vs_table">
				<tr class="vs_tblHead">
					<th>Registered Courses</th>
					<th class="vs_checkST">Status</th>
				</tr>
				<?php 
					foreach ($result as $key => $value)
					{
					
				?>
				<tr class="vs_data">
					<td><a href="lessons.php?courseID=<?=$value['ID']?>&course=<?=$value['course_title']?>" class="vs_courseTitle" title="<?=$value['course_title']?>">► <?=$value['course_title']?></a></td>
					<td class="vs_checkST"><span class="fa fa-check-square" style="font-size: 25px;" aria-hidden='true'></span></td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
	</div>
</body>
</html>