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
<link rel="stylesheet" href="css/ui_minified/jquery-ui.min.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/images/main.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>

<script src="js/ui/jquery.ui.core.js"></script>
<script src="js/ui/jquery.ui.widget.js"></script>
<script src="js/ui/jquery.ui.position.js"></script>
<script src="js/ui/jquery.ui.menu.js"></script>
<script src="js/ui/jquery.ui.autocomplete.js"></script>

<script src="js/showposition.js"></script>




<script type="text/javascript">
    $(document).ready(function() {
        $('#slider').nivoSlider();
    });
</script>

<script>
	$(function() {
		function log( message ) {
			$( "#result" ).text( message ).prependTo( "#result" );
			$( "#result" ).scrollTop( 0 );
		}

		$( "#positionname" ).autocomplete({
			source: "search.php",
			minLength: 2,
			select: function( event, ui ) {
			   /*	log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );*/
			}
		});
	});

    $(function() {

		$( "#streetname" ).autocomplete({
			source: "streetsearch.php",
			minLength: 2,
			select: function( event, ui ) {
                 $('#streetid').val(ui.item.id);
				//log( ui.item ?
				//	"Selected: " + ui.item.value + " aka " + ui.item.id :
				//	"Nothing selected, input was " + this.value );
			}
		});
	});

    jQuery.fn.setGroup = function (groupid) {
        $('#groupid').val(groupid);
        $('a[name=group]').css({"background-color":"white","width":"40px","height":"30px","border":"0px solid" });
        $(this).css({"background-color":"yellow","width":"50px","height":"40px","border":"1px solid" });
    }
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
                    include("menu.php");

            ?>
             <?php
                 if (!isset($_SESSION['UserName'])):
             ?>
                        <div class="Login">
                         <form method="post"  action="cp/actions.php">
                            <label class="right">نام کاربري:</label> <input type="text" name="txtname" size="20"  /><br />
                            <label class="right">کلمه عبور:</label>  <input type="password" name="txtpass" size="20"  /><br />
                            <input type="hidden" name="from" value="0" />
                            <input type="hidden" name="act" value="0" />
                            <label ><?php echo $_SESSION['Error']; $_SESSION['Error']="";?> </label><br />

                            <input type="submit" name="btnlogin" value="ورود" class="right"/>  <br /> <br />

                            <label class="right registeruser"><a href="users.php" > ثبت نام </a></label>

                         </form>
                        </div>
            <?php endif; ?>
            <br />
        </td>


        <!-- Main -->

        <td id="Main">
        <div>
             <div class="address"><div class="name"><label> <?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?> </label></div>
                <form method="post" action="cp/actions.php">

                        <input type="text" name="positionname" id="positionname" class="ui-widget" placeholder="به دنبال چه هستید؟" size="25" style="margin-left:20px;"/>

                        <input type="text" name="streetname" id="streetname" class="ui-widget" placeholder="نام خیابان" size="20" style="margin-left:20px;"/>

                        <input type="hidden" name="streetid" id="streetid" value="0"/>
                        <input type="hidden" name="groupid" id="groupid" value="0"/>

                         <input name="from"  value="2" type="hidden"/>
                         <input name="act"  value="3" type="hidden"/>


                    <input type="image" src="css/images/search.png" align="absmiddle" name="Search" onclick="$(this).showposition();return false;">
                </form>

             </div>
             <div dir="rtl" style="width:460px;position:relative;right:215px;margin-top:15px">
                  <a href="#" name="group" onclick="$(this).setGroup(1)"><img border="0" src="css/images/buy.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(2)"><img border="0" src="css/images/auto.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(3)"><img border="0" src="css/images/clothes.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(4)"><img border="0" src="css/images/restaurant.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(5)"><img border="0" src="css/images/hospital.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(6)"><img border="0" src="css/images/barber.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(7)"><img border="0" src="css/images/health.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(8)"><img border="0" src="css/images/people.png"></a>
                  <a href="#" name="group" onclick="$(this).setGroup(9)"><img border="0" src="css/images/sport.png"></a>
             </div>
<!--
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

                </div>    <!--End of posiotion-->

              <div id="result">

              </div>

         </div>



        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
