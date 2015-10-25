<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)



		if (	!(isset($_POST["name"]) && strcmp("", $_POST["name"])) || 
				!(isset($_POST["mn"]) && strcmp("", $_POST["mn"])) ||
				!(isset($_POST["cn"]) && strcmp("", $_POST["cn"])) ||
				!(isset($_POST["cc"]) && strcmp("", $_POST["cc"])) ) {

		?>
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. <a href="fruitstore.html">Try again?</a></p>

		<?php
		} elseif (!(preg_match("/^([a-zA-Z][\-| ]?)*([a-zA-Z])$/",$_POST["name"]))) {		
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="fruitstore.html">Try again?</a></p>
		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		} elseif (!(($_POST["cc"]==="Master"&&preg_match("/^5[0-9]{15}$/",$_POST["cn"])) || ($_POST["cc"]==="Visa"&&preg_match("/^4[0-9]{15}$/",$_POST["cn"])))) {
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="fruitstore.html">Try again?</a></p>

		<?php
		# if all the validation and check are passed 
		} else {
		?>

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->

		<ul> 
			<li>Name: <?= $_POST["name"] ?> </li>
			<li>Membership Number: <?= $_POST["mn"] ?> </li>
			<li>Options: <?= implode(", ", $_POST["op"]) ?></li>
			<li>Fruits: <?= $_POST["fruit"]." - ".$_POST["quantity"] ?></li>
			<li>Credit <?= $_POST["cn"]." (".$_POST["cc"].")" ?></li>
		</ul>
		
		
		<p>This is the sold fruits count list:</p>
		<?php
			$filename = "customers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
			 * For example, "Scott Lee;20110115238;apple;3"
			 */
			$str = $_POST["name"].";".$_POST["mn"].";".$_POST["fruit"].";".$_POST["quantity"]."\n";
			file_put_contents($filename, $str, FILE_APPEND);

		?>
		
		<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
			Create unordered list to show the number of fruit sold -->
		<ul>
		<?php 
			$fruitcounts = soldFruitCount($filename);
			foreach($fruitcounts as $line) {
		?>
				<li> <?= $line ?></li>
		<?php
		}
		?>
		</ul>
		
		<?php
		}
		?>
		
		<?php
			/* Ex 3 :
			* Get the fruits species and the number from "customers.txt"
			* 
			* The function parses the content in the file, find the species of fruits and count them.
			* The return value should be an key-value array
			* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
			*/
			function soldFruitCount($filename) { 
				$arr = file($filename);
				$me = 0;
				$ap = 0;
				$or = 0;
				$st = 0;
				foreach ($arr as $ar) {
					$ar = explode(";", $ar);
					if($ar[2] == "Melon") {
						$me += $ar[3];
					} else if($ar[2] == "Apple") {
						$ap += $ar[3];
					} else if($ar[2] == "Orange") {
						$or += $ar[3];
					} else {
						$st += $ar[3];
					}
				}
				$re;
				$re[0] = "Melon"." - ".$me;
				$re[1] = "Apple"." - ".$ap;
				$re[2] = "Orange"." - ".$or;
				$re[3] = "Strawberry"." - ".$st;

				return $re;
			}
		?>
		
	</body>
</html>
