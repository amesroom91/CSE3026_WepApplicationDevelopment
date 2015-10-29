<!DOCTYPE html>
<html>
	<head>
		<title>TEST</title>
	</head>

	<body>
		<?php 
		$name = $_POST["db"];
		$str = $_POST["str"];


		try{
			$db = new PDO("mysql:dbname=".$name, "root", "root");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
 		catch (PDOException $ex) {
    	?>
    		<p>Sorry, a database error occurred. Please try again later.</p>
    		<p>(Error details: <?= $ex->getMessage() ?>)</p>
		<?php }
		$rows = $db -> query($str);
		?>
		


		<ul>
		<?php
		foreach ($rows as $row) {
			$s = implode("|", $row);
			$s = explode("|", $s);
			$cnt = count($s);
		?>	
				<li>
					<?php
						for($i=0; $i<$cnt; $i+=2) { ?>
							<?= $s[$i] ?>
						<?php 
						}
					?>
				</li>
		<?php
		}

		?>
		</ul>

	</body>
</html>




<!-- foreach($result as $results)
	{

	?>
		<li>
			<?php for($i=0;$i<$result->rowCount();$i++){?>
			<?= $results[$i] ?>
			<?php } ?>
		</li>
 -->