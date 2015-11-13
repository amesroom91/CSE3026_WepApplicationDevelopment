<?php
    class TimeLine {
        # Ex 2 : Fill out the methods
        private $db;
        
        function __construct()
        {
            $this->db = new PDO("mysql:host=localhost;dbname=timeline", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function add($tweet) // This function inserts a tweet
        {   

            /*  0123456789012345678
                2015-11-13 01:19:44 
                hour:minute:second date/month/year 
                SELECT DATE_FORMAT(NOW(), '%h:%i:%s %d/%m/%y'); 

                DB > DATETIME은 정해진 포맷만 저장가능한 듯.
                */

            /* SQL Injection Avoidance */
            $this->db->quote($tweet[0]);
            $this->db->quote($tweet[1]);
            

            
            $str = "INSERT INTO tweets(author, contents, time) VALUES ('$tweet[0]', '$tweet[1]', Now())";
            $this->db->exec($str);
            
        }
        public function delete($no) // This function deletes a tweet
        {
            $this->db->exec("DELETE FROM tweets WHERE no = '$no'");
        }
        
        # Ex 6: hash tag
        # Find has tag from the contents, add <a> tag using preg_replace() or preg_replace_callback()
        public function loadTweets() // This function load all tweets
        {            
            $rows = $this->db->query("SELECT * FROM tweets Order by time DESC");
            $rows = $rows->fetchAll();
            $i = 0;
            foreach ($rows as $row) {
                $con = $row['contents'];
                // str_replace("<a href=\"index.php?type=Content&query=%23$1\">", " ", $con);
                // str_replace("</a>", "", $con);

                if(strpos($con, "#039") > -1) {

                } else {
                    $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                    $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);    
                }
                
                //$this->db->exec("UPDATE tweets SET contents = '$con' WHERE no = '$row[0]'");
                //$row[2] = $con;
                $rows[$i]['contents'] = $con;
                $i++;
            }

            return $rows;
        }
        public function searchTweets($type, $query) // This function load tweets meeting conditions
        { 
            if(!strcmp($type,"Author")) {
                $rows = $this->db->query("SELECT * FROM tweets WHERE author LIKE '%$query%' Order by time DESC");
                $rows = $rows->fetchAll();
                $i = 0;
                foreach ($rows as $row) {
                    $con = $row['contents'];
                    // str_replace("<a href=\"index.php?type=Content&query=%23$1\">", " ", $con);
                    // str_replace("</a>", "", $con);

                    if(strpos($con, "#039") > -1) {

                    } else {
                        $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                        $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);    
                    }

                    $rows[$i]['contents'] = $con;
                    $i++;
                    // $row[2] = $con;
                }
            } else if(!strcmp($type,"Content")) {
                $rows = $this->db->query("SELECT * FROM tweets WHERE contents LIKE '%$query%' Order by time DESC");
                $rows = $rows->fetchAll();
                $i = 0;
                foreach ($rows as $row) {
                    $con = $row['contents'];
                    // str_replace("<a href=\"index.php?type=Content&query=%23$1\">", " ", $con);
                    // str_replace("</a>", "", $con);
                    if(strpos($con, "#039") > -1) {

                    } else {
                        $tag = "<a href=\"index.php?type=Content&query=%23$1\">#$1</a>";
                        $con = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $tag, $con);    
                    }
                    $rows[$i]['contents'] = $con;
                    $i++;
                    // $row[2] = $con;
                }
            }
            return $rows;    
        }
            
    }
?>