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
	<link rel="stylesheet" type="text/css" href="./css/mainStyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="courseContainer">
		<div class="courseHeading">
			<h2>All Courses</h2>
		</div>
		<div class="courseListContainer">
			<table class="coursetbl">
				<tr class="tblHead">
					<th>Registered Courses</th>
					<th class="checkST">Status</th>
				</tr>
				<?php 
					foreach ($result as $key => $value)
					{
					
				?>
				<tr class="tblData">
					<td><a href="lessons.php?courseID=<?=$value['ID']?>&course=<?=$value['course_title']?>" class="courseTitle" title="<?=$value['course_title']?>">► <?=$value['course_title']?></a></td>
					<td class="checkST"><span class="fa fa-check-square" style="font-size: 25px;" aria-hidden='true'></span></td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
	</div>
</body>
</html>