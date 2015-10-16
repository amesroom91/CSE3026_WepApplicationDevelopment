<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
    
    <?php 
        $filename = file("courses.tsv");
        $lines = count($filename);
        $size = filesize("courses.tsv");
    ?>

    <p>
        Course list has <?=$lines?> total courses and size of <?=$size?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>



<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
            
            if(isset($_GET["number_of_courses"])) {
                $numberOfCourses = $_GET["number_of_courses"];
                if($_GET["number_of_courses"] == "") {
                    $numberOfCourses = 3;
                }
            } else {
                $numberOfCourses = 3;
            }
            $todaysCourse = getCoursesByNumber($filename, $numberOfCourses);

            function getCoursesByNumber($listOfCourses, $numberOfCourses){
                $resultArray = array();
                shuffle($listOfCourses);
                $i = count($listOfCourses);
                for(; $i > $numberOfCourses; $i--) {
                    array_pop($listOfCourses);
                }
                $resultArray = $listOfCourses;
                return $resultArray;
            }
        ?>

        <ol>
        <?php
            foreach ($todaysCourse as $des) {
                $words = explode("\t", $des);
                $words = implode(" - ", $words);
        ?>
                <li><?=$words?></li>
        <?php
            }
        ?>
        </ol>
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        <?php
            $startCharacter = 'C';

            $newArr = array();
            foreach ($filename as $z) {
                $formChange = explode("\t", $z);
                $formChange = implode(" - ", $formChange);    
                array_push($newArr, $formChange);
            }
                
            $startCharacter = 'C';
            if(isset($_GET["character"])) {
                $startCharacter = $_GET["character"];
                if($_GET["character"] == "") {
                    $startCharacter = 'C';
                }
            } else {
                $startCharacter = 'C';
            }


            function getCoursesByCharacter($listOfCourses, $startCharacter){
                $resultArray = array();
                foreach ($listOfCourses as $des) {
                    if($startCharacter == substr($des, 0, 1)) {
        ?> 
                    <li><?=$des?></li>
        <?php
                    }
                }
                return $resultArray;
            }

            
        ?>

        <p>
            Courses that started by <strong>'<?=$startCharacter?>'</strong> are followings :
        </p>
        <ol>
            <?php getCoursesByCharacter($newArr, $startCharacter); ?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php


            $orderby = 0;
            if(isset($_GET["orderby"]) && $_GET["orderby"] == '1') {
                $orderby = 1;
                if($_GET["orderby"] == "") {
                    $orderby = 0;
                }
            } else {
                $orderby = 0;
            }

            function getCoursesByOrder($listOfCourses, $orderby){
                $resultArray = $listOfCourses;
                if($orderby == 0) {
                    sort($resultArray);
                } else {
                    rsort($resultArray);
                }
                return $resultArray;
            }


        ?>

        <p>
            All of courses ordered by <strong>alphabetical order</strong> are followings :
        </p>
        <ol>
            <?php
                foreach (getCoursesByOrder($newArr, $orderby) as $p) {
                $tempCourse = explode(" -", $p);
                if(strlen($tempCourse[0]) > 20) {
            ?>
                    <li class="long"><?=$p?></li>
            <?php
                } else {
            ?>
                    <li><?=$p?></li>
            <?php
                }
            }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
    <?php 
            $newCourse;
            $codeOfCourse;

            if(!isset($_GET["new_course"]) || !isset($_GET["code_of_course"])) {
        ?>
                <p>Input course or code of the course doesn't exist.</p>
        <?php
            } else {
        ?>
                <p>Adding a course is success!</p>
        <?php
                $newCourse = $_GET["new_course"];
                $codeOfCourse = $_GET["code_of_course"];
                $next = "\n".$newCourse."\t".$codeOfCourse;    
                file_put_contents("courses.tsv", $next, FILE_APPEND);
            }
        ?>

    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>