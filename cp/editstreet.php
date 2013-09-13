<?php
//------------------check login-------------------------------------------------
     session_start();
     $ClientString = $_SERVER['HTTP_USER_AGENT'] .
     $_SERVER['REMOTE_ADDR'];
     if( !isset( $_SESSION['UserName']) || $_SESSION['ClientStr'] != md5(
            $ClientString))
    {
      header( "location: ../index.php" );
      exit();
    }
//------------------------------------------------------------------------------
    include("functions.php");

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $uid=$_SESSION['uid'];
        $query = "SELECT name FROM `street` WHERE sid='$id' and uid=$uid";
           $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if(mysql_affected_rows()){
           $row=mysql_fetch_array($Result);
           $name=$row['name'];
        }
       // mysql_free_result();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="../css/images/main.css" type="text/css" />

    <title>ويرايش خيابان</title>

</head>

<body dir="rtl">
    <center >

        <table id="tblmain"  width="80%" border="1" dir="rtl">

        <!-- Header -->
        <tr class="Header"> <td colspan="3" class="HeaderPic" ></td></tr>

        <!-- Right -->
         <td id="Right" >
         <?php
                include("menu.php");
         ?>


             </td>


        <!-- Main -->

        <td id="Main">
        <div>
           <div class="address"><pre>ويرايش خيابان</pre></div>
        <?php if(isset($_SESSION['streetmes'])) echo "<div class='message'>".$_SESSION['streetmes'] ."</div>";?>   <!--show a message from action -->
            <div><form method="post" action="actions.php">
            <table>
                <tr class="inter"><td>نام :</td><td><input type="text" name="txtname" value="<?php echo $name?>" /></td></tr>
                 <input type="hidden" name="from"  value="4"/>
                 <input type="hidden" name="act"  value="4"/>
                 <input type="hidden" name="id"  value="<?php echo $id?>"/>
                <tr><td><input type="submit" value="ثبت" name="send"  class="btn" /> </td><td><a href="street.php"> <img src="../css/images/back.png" ></a></td></tr>

            </table></form></div>


     </div>
        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
