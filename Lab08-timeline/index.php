<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simple Timeline</title>
        <link rel="stylesheet" href="timeline.css">
    </head>
    <body>
        <div>
            <a href="index.php"><h1>Simple Timeline</h1></a>
            <div class="search">
                <!-- Ex 3: Modify forms -->
                <form class="search-form" method="get" action="index.php">
                    <input type="submit" value="search">
                    <input type="text" name="query" placeholder="Search">
                    <select name="type">
                        <option>Author</option>
                        <option>Content</option>
                    </select>
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <!-- Ex 3: Modify forms -->
                    <form class="write-form" method="post" action="add.php">
                        <input type="text" placeholder="Author" name="wau">
                        <div>
                            <input type="text" placeholder="Content" name="wco">
                        </div>
                        <input type="submit" value="write">
                    </form>
                </div>
                <!-- Ex 3: Modify forms & Load tweets -->
                <?php 
                    include "timeline.php";
                    $tl = new Timeline();


                    if(!isset($_GET["query"])) {
                        $rows = $tl->loadTweets();
                        foreach ($rows as $row) { 
                            /* Hash Tag */
                            // $con = $row[2];
                            // $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                            // $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);
                            // $row[2] = $con;

                            /* Time Format */
                            $hour = substr($row[3], 11, 8);
                            $date = substr($row[3], 8, 2);
                            $month = substr($row[3], 5, 2);
                            $year = substr($row[3], 0, 4);
                            $time = $hour." ".$date."/".$month."/".$year;

                            ?>
                            <div class="tweet">
                                <form class="delete-form" method="post" action="delete.php">
                                    <input type="hidden" name="no" value="<?= $row[0] ?>">
                                    <input type="submit" value="delete">
                                </form>
                                <div class="tweet-info">
                                    <span><?= $row[1]; ?></span>                                
                                    <span><?= $time; ?></span>
                                </div>
                                <div class="tweet-content">
                                    <?= $row['contents']; ?>
                                </div>
                            </div>            
                            <?php 
                        }
                    }
                          
                    else if(isset($_GET["type"]) && isset($_GET["query"])) {
                        $qry = $_GET["query"];
                        $newQry = htmlspecialchars($qry, ENT_QUOTES);
                        $rows = $tl->searchTweets($_GET["type"], $newQry);

                        foreach ($rows as $row) { 

                            /* Hash Tag */
                            // $con = $row[2];
                            // $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                            // $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);
                            // $row[2] = $con;
                            
                            /*  Time Format
                                0123456789012345678
                                2015-11-13 01:19:44 
                                hour:minute:second date/month/year 
                                SELECT DATE_FORMAT(NOW(), '%h:%i:%s %d/%m/%y'); */
                            $hour = substr($row[3], 11, 8);
                            $date = substr($row[3], 8, 2);
                            $month = substr($row[3], 5, 2);
                            $year = substr($row[3], 0, 4);
                            $time = $hour." ".$date."/".$month."/".$year;

                            ?>
                            <div class="tweet">
                                <form class="delete-form" method="post" action="delete.php">
                                    <input type="hidden" name="no" value="<?= $row[0] ?>">
                                    <input type="submit" value="delete">
                                </form>
                                <div class="tweet-info">
                                    <span><?= $row[1]; ?></span>                                
                                    <span><?= $time; ?></span>
                                </div>
                                <div class="tweet-content">
                                    <?= $row['contents']; ?>
                                </div>
                            </div>            
                        <?php
                        }
                    } else {
                        $rows = $tl->loadTweets();
                        foreach ($rows as $row) { 
                            /* Hash Tag */
                            // $con = $row[2];
                            // $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                            // $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);
                            // $row[2] = $con;

                            /* Time Format */
                            $hour = substr($row[3], 11, 8);
                            $date = substr($row[3], 8, 2);
                            $month = substr($row[3], 5, 2);
                            $year = substr($row[3], 0, 4);
                            $time = $hour." ".$date."/".$month."/".$year;

                            ?>
                            <div class="tweet">
                                <form class="delete-form" method="post" action="delete.php">
                                    <input type="hidden" name="no" value="<?= $row[0] ?>">
                                    <input type="submit" value="delete">
                                </form>
                                <div class="tweet-info">
                                    <span><?= $row[1]; ?></span>                                
                                    <span><?= $time; ?></span>
                                </div>
                                <div class="tweet-content">
                                    <?= $row['contents']; ?>
                                </div>
                            </div>            
                        <?php
                        }
                    } ?>
                
            </div>
        </div>
    </body>
</html>


