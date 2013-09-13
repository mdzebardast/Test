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

       // mysql_free_result();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="../css/images/main.css" type="text/css" />

<link rel="stylesheet" href="../css/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/ui_minified/jquery-ui.min.css" type="text/css" media="screen" />

<link rel="stylesheet" href="../css/images/main.css" type="text/css" />

<script language="javascript" src="../js/validator.js"></script>

<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider').nivoSlider();
    });
</script>

    <title>ويرايش موقعيت</title>

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
           <div class="address"><pre>ويرايش موقعيت</pre></div>
        <?php if(isset($_SESSION['streetmes'])) echo "<div class='message'>".$_SESSION['streetmes'] ."</div>";?>   <!--show a message from action -->
            <div>
                <?php showposition("","",0,0,6); ?>
            </div>


     </div>
        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
