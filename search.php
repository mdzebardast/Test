<?php

require("cp/config.php");

// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
// remove slashes if they were magically added
$q = stripslashes($q);
$q=mysql_real_escape_string($q);


$query="SELECT name FROM `position` WHERE NAME LIKE '%$q%' OR keywords LIKE '%$q%' LIMIT 10";

/*$query="SELECT pos.name FROM `group` g
	JOIN `positiongroup` pg ON g.`gid` = pg.`gid`
	JOIN `position` pos ON pos.pid=pg.`pid`
WHERE g.`parentid`= $groupid AND  (pos.`name` LIKE '%$q%' OR pos.keywords LIKE '%$q%')  LIMIT 10 ";
*/

$result=mysql_query($query);
$positions = array();

	while( $row= mysql_fetch_array( $result ) ){
         $row['name'] = htmlspecialchars($row['name']);
	     $row['name'] = str_replace(array("\n", "\r"), ' ',$row['name']);
//         echo $row['name'];
         array_push($positions, array("id"=>$row['name'], "label"=>$row['name'], "value" => strip_tags($row['name'])));
    }

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($positions);

?>