<?php
	# Ex 5 : Delete a tweet
    include "timeline.php";
    $tl = new Timeline();
	
	try {
    	$tl->delete($_POST["no"]);
    	header("Location:index.php");
	} catch(Exception $e) {
	    header("Location:error.php"); 
	}
?>
