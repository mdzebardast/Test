<?php
     session_start();
     $ClientString = $_SERVER['HTTP_USER_AGENT'] .$_SERVER['REMOTE_ADDR'];
        if( !isset( $_SESSION['UserName']) || $_SESSION['ClientStr'] != md5(
            $ClientString))
    {
      header( "location: ../index.php" );
      exit();
    }

    include("functions.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/images/main.css" type="text/css" />

<script language="javascript" src="../js/validator.js"></script>
    <title>خيابان</title>

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
             <div class="address"><pre>خيابان</pre></div>

            <div><form method="post" action="actions.php">
            <table>
                <tr class="inter"><td>نام :</td><td><input type="text" name="txtname"  /></td></tr>
                 <input type="hidden" name="from" value="3"/>
                 <input type="hidden" name="act" value="1"/>
                <tr><td><input type="submit" value="ثبت" name="send"  class="btn" /> </td></tr>
            </table></form></div>

            <?php
                 if(isset($_SESSION['street'])) echo "<div class='message'>".$_SESSION['street'] ."</div>";  // <!--show a message from action -->
                $_SESSION['street']="";
                echo '<div class="Alter inter"> <center>خيابان</center></div>';
                showstreet();  //show a list of banks
            ?>

     </div>
        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
