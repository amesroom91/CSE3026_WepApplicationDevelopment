<!DOCTYPE html>
<html>
	<head>
		<title>Grade Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php
		if (	!(isset($_POST["name"]) && strcmp("", $_POST["name"])) || 
				!(isset($_POST["id"]) && strcmp("", $_POST["id"])) ||
				!(isset($_POST["cn"]) && strcmp("", $_POST["cn"])) ||
				!(isset($_POST["cc"]) && strcmp("", $_POST["cc"]))||
				!(isset($_POST["grade"]) && strcmp("", $_POST["grade"]))) {
		?>

		
			
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. <a href="gradestore.html">Try again?</a></p>
		

		<?php
		} elseif (!(preg_match("/^([a-zA-Z\-][ ]?)+$/",$_POST["name"]))) {		
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="gradestore.html">Try again?</a></p>
		

		<?php
		} elseif (!(($_POST["cc"]==="master"&&preg_match("/^5[0-9]{15}$/",$_POST["cn"])) || ($_POST["cc"]==="visa"&&preg_match("/^4[0-9]{15}$/",$_POST["cn"])))) {
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="gradestore.html">Try again?</a></p> 
		<?php
		} else {
		?>

		<h1>Thanks, looser!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<ul> 
			<li>Name: <?= $_POST["name"] ?> </li>
			<li>ID: <?= $_POST["id"] ?> </li>
			<li>Course: <?php processCheckbox($_POST["course"]); ?></li>
			<li>Grade: <?= $_POST["grade"] ?> </li>
			<li>Credit Card: <?= $_POST["cn"]." (". $_POST["cc"].")"  ?> </li>
		</ul>
		
		
			<p>Here are all the loosers who have submitted here:</p>
		<?php
			$filename = "loosers.txt";
			$str = $_POST["name"].";".$_POST["id"].";".$_POST["cn"].";".$_POST["cc"]."\n";
			file_put_contents($filename, $str, FILE_APPEND);
		?>
		
		<pre>
<?php echo file_get_contents($filename); ?>
		</pre>

		
		<?php
		}
		?>
		
		<?php
			function processCheckbox($courses){
				$counter = 1;
				foreach ($courses as $course) {
					if($counter < count($courses)) {
						echo $course.", ";
						$counter++;
					} else {
						echo $course;
					}
				}
			}
		?>
		
	</body>
</html>
