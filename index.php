<?php
     session_set_cookie_params(0,"./".basename(getcwd())."/");
     session_start();
     if(!isset($_SESSION['Error'])){
        $_SESSION['Error']="";
     }
    if(isset($_POST['btnlogout']))
    {
        $_SESSION['UserName']=Null;    //destroy variable
        $_SESSION['Error']=Null;
        session_destroy();
    }
    //include("functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title> Jaajoor </title>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="icon" href="css/images/favicon.ico" type="image/x-icon">


<link rel="stylesheet" href="css/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/images/main.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
</script>


</head>
<body dir="rtl">
    <center >

        <table id="tblmain"  width="80%" border="1" dir="rtl">

        <!-- Header -->
        <tr class="Header"> <td colspan="3" class="HeaderPic" ></td></tr>

        <!-- Right -->
         <td id="Right" >
            <?php
                 if (isset($_SESSION['UserName']))
                    //include("menu.php");
            ?>
            <br />
        </td>


        <!-- Main -->

        <td id="Main">
        <div>
             <div class="address"><div class="name"><?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?></div>
                <form method="post" action="cp/actions.php">
                    <input type="text" name="posiotionname" placeholder="به دنبال چه هستید؟" size="20"/>
                    <input type="text" name="streetname" placeholder="نام خیابان" size="20"/>
                    <input type="image" src="css/images/search.png" align="absmiddle" name="Search">
                </form>

             </div>


                <div class="position">
                    <label> رستوران رانا </label><hr />
                        <ul class="information">
                            <li><label> فکس :</label> <label> 888222333 </label></li>
                            <li><label> تلفن :</label> <label> 888222443 </label></li>
                            <li><label> ايميل :</label> <label> info@gmail.com </label></li>
                            <li><label> وب سايت :</label> <label> webdesign.com </label></li>
                            <li><label> آدرس :</label> <label> تهران - خ آزادي </label> </li>
                            <li><label></label></li>
                        </ul>

                     <div class="logo"><img src="images/logo.png" /></div>

                    <div class="slider-wrapper theme-light">
                        <div id="slider" class="nivoSlider">
                            <img src="images/toystory.jpg" data-thumb="images/toystory.jpg" alt="" />
                            <img src="images/walle.jpg" data-thumb="images/walle.jpg" alt="" data-transition="slideInLeft" />
                            <img src="images/nemo.jpg" data-thumb="images/nemo.jpg" alt="" title="#htmlcaption" />
                        </div>
                    </div>
                    <hr />
              </div>


         </div>
        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
