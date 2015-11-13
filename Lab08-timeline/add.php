<?php
    # Ex 4 : Write a tweet
    include "timeline.php";
    $tl = new Timeline();

    try {

        if (preg_match("/^[a-zA-Z]+([\ \-]?[a-zA-Z]+)*$/",$_POST["wau"]) && (strlen($_POST["wau"]) <= 20) && (strlen($_POST["wau"]) >= 1)) { 
            $tweet = array();

            /* HTML 방지 */
            $aut = $_POST["wau"];
            $con = $_POST["wco"];
            $newCon = htmlspecialchars($con, ENT_QUOTES);
            $newAut = htmlspecialchars($aut, ENT_QUOTES);

            array_push($tweet, $newAut);
            array_push($tweet, $newCon);
            $tl->add($tweet);
            header("Location:index.php");
        } else {
            header("Location:error.php");
        }
    } catch(Exception $e) {
        header("Location:error.php");
    }
?>
