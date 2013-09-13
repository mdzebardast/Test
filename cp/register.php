<?php
    session_start();
     $ClientString = $_SERVER['HTTP_USER_AGENT'] .$_SERVER['REMOTE_ADDR'];
        if( !isset( $_SESSION['UserName']) || $_SESSION['ClientStr'] != md5($ClientString) || $_SESSION['type']!=3)
    {
      header( "location: index.php" );
      exit();
    }
    if(!isset($_SESSION['regMes'])){
        $_SESSION['regMes']="";
    }

   include("functions.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/images/main.css" type="text/css" />

<script language="javascript" src="../js/validator.js"></script> 

    <title>مديريت کاربر</title>

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
        <div class="address"><div class="name">نام : <?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?></div><pre>کاربر</pre></div>
            <center><br/><div >
                <form  method="POST" action="actions.php">
                       <table >
                            <tr class="titletd"> <td ><p>نام :    </td><td> <input type="text" name="Name"  size="20"></p></td></tr>
                            <tr class="titletdeven"> <td ><p>  نام کاربري :    </td>    <td> <input type="text" name="UserName"  size="20" ></p></td></tr>
                            <tr class="titletd"> <td ><p> کلمه عبور :    </td>    <td> <input type="password" name="Password"  size="20"></p></td></tr>
                            <tr class="titletdeven"> <td ><p> تکرار کلمه عبور :    </td>    <td> <input type="password" name="ConfirmPassword"  size="20"></p></td></tr>
                           <tr class="titletd"><td ><p>ايميل :</td><td> <input type="text" name="Email" size="20"  onblur="validate(this.value)"> </td></tr></p>
                           <input type="hidden" name="from" value="0" />
                           <input type="hidden" name="act" value="1" />
                             <tr><td></td><td> <p><input type="submit" value="ثبت نام" name="register" class="btn" onclick="validate()"></p></td></tr>
                       </table>
                </form>
                <div id="message"><?php echo $_SESSION['regMes']; $_SESSION['regMes']=""; ?></div>
            </div></center>
            <div>
                <div class="Alter"> <center>کاربران</center></div>
                <?php
                    showuser();
                ?>
            </div>

        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>


