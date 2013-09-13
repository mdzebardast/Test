<?php

require("cp/config.php");

// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
// remove slashes if they were magically added
$q = stripslashes($q);
$q=mysql_real_escape_string($q);

$query="SELECT sid,name FROM street WHERE NAME LIKE '%$q%' LIMIT 10";

$result=mysql_query($query);
$positions = array();

	while( $row= mysql_fetch_array( $result ) ){
         $row['name'] = htmlspecialchars($row['name']);
         $row['sid'] = htmlspecialchars($row['sid']);
	     $row['name'] = str_replace(array("\n", "\r"), ' ',$row['name']);
//         echo $row['name'];
         array_push($positions, array("id"=>$row['sid'], "label"=>$row['name'], "value" => strip_tags($row['name'])));
    }

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($positions);

?>