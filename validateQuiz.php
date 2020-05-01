<?php
extract($_POST);
extract($_GET);
session_start();
print_r($_POST);
$userID = $_SESSION['userID'];
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


/*************New Code **********/


//If Fail. Just update score and status = 0
if($score < 80) {
    
    //Update score and status
    $sqlUpdate = "UPDATE `user_quiz` SET score = $score, status = 0 WHERE user_id = $userID AND module_id=$quizID AND module='quiz'";
    
    
    if(mysqli_query($con, $sqlUpdate)){
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: " . mysqli_error($con);
    }


} else {

    //**********************PASS*******************

    //Update score and status
    $sqlUpdate = "UPDATE `user_quiz` SET score = $score, status = 1 WHERE user_id = $userID AND module_id=$quizID AND module='quiz'";
    
    
    if(mysqli_query($con, $sqlUpdate)){
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: " . mysqli_error($con);
    }
    
    
    $lastQuizId = getNextId ('quiz', $quizID);
    
    //If $lastQuizId is 0 then the current quiz is last quiz. Because Quiz is pass so update Lesson stauts to 1
    if($lastQuizId == 0) { 
        
        //Update Lesson record in the User_Quiz table
        //----SQL CODE -----
        // echo " Last Quiz ID : ".$lastQuizId;
    	$updateLessonQuery = "UPDATE user_quiz SET status = 1 WHERE module_ID = $lessonID AND module = 'lesson'";
    	if(mysqli_query($con,$updateLessonQuery))
    	{
    		echo "<br>Lesson Status Updated";
    	}
        
        //Find the next lesson
        $lastLessonId = getNextId ('lesson', $lessonID);

            if($lastLessonId == 0) {
        
                //Update Course record in the User_Quiz table
                $updateLessonQuery = "UPDATE user_quiz SET status = 1 WHERE module_ID = $courseID AND module = 'course'";
                if(mysqli_query($con,$updateLessonQuery))
                {
                	echo "<br>Course Status Updated";
                }

            } else {
                //If last lesson id is not 0 then create record of the next Lesson
                
                $newLessonQuery = "INSERT INTO `user_quiz`(`user_ID`, `module_ID`, `module`, `score`, `status`) VALUES ($userID,$lastLessonId,'lesson',0,0)";
                if(mysqli_query($con,$newLessonQuery))
                {
                	echo "<br>New Lesson Unlocked";
                }
                else
                {
                	mysqli_error($con);
                }
            }
        
    } else {
                //If last quiz id is not 0 then create record of the next quiz
                // echo " Last Quiz ID : ".$lastQuizId;
                $newLessonQuery = "INSERT INTO `user_quiz`(`user_ID`, `module_ID`, `module`, `score`, `status`) VALUES ($userID,$lastQuizId,'quiz',0,0)";
                if(mysqli_query($con,$newLessonQuery))
                {
                	echo "<br>New quiz Unlocked";
                }
                else
                {
                	mysqli_error($con);
                }
            }
}

//Function to get the next ID. If no next record then it returns 0

function getNextId ($module, $currentId) {
	include './connection/connection.php';
	// echo $module;
    //Get sql to run
    $lessonID = $_GET['lessonID'];
    $courseID = $_GET['courseID'];
    $resultLastId = '';
    $isCurrent = 0;
    $lastId = 0;
    switch($module) {
        case 'quiz':
		            $sqlLastId = "SELECT * FROM `learning_quiz` WHERE lesson_ID = $lessonID ORDER BY `learning_quiz`.`ID` ASC";
		            $resultLastId = mysqli_query($con,$sqlLastId) or die(mysqli_error($con));
		            foreach ($resultLastId as $key => $value)
		            {
	            	    //Is the id same as current
	            	     //If record-pointer passed the current then capture the ID as next id and get out
		                if($isCurrent == 1) {
		                     $lastId = $value['ID'];
		                     break;
		                }
	            		if($currentId == $value['ID'])
	            		{
	            		       $isCurrent = 1;

	            		}
		               
		            }
            // return $lastId;
            break;
        case 'lesson':
			        $sqlLastId = "SELECT * FROM `learning_lessons` WHERE course_ID = $courseID ORDER BY `learning_lessons`.`ID` ASC";
			        $resultLastId = mysqli_query($con,$sqlLastId) or die(mysqli_error($con));
			        foreach ($resultLastId as $key => $value)
			        {
			        	//If record-pointer passed the current then capture the ID as next id and get out
			        	if($isCurrent == 1) {
			        	     $lastId = $value['ID'];
			        	     break;
			        	}
			        	//Is the id same as current
			        	if($currentId == $value['ID'])
			        	{
			        	       $isCurrent = 1;

			        	}
			        }
			        // return $lastId;
			        break;
    }
    
    ////// I Moved this code to inside Switch-case ↓↓↓↓
   
    //mysqli_fetch_array($resultLastId));
    // foreach ($resultLastId as $key => $value)
    // {
    //     //If record-pointer passed the current then capture the ID as next id and get out
    //     if($isCurrent == 1) {
    //          $lastId = $value['ID'];
    //          break;
    //     }								
        
    //     //Is the id same as current
    // 	if($currentId == $value['ID'])
    // 	{
    // 	       $isCurrent = 1;

    // 	}
    // }
    
    return $lastId;

}
/**********************/

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
