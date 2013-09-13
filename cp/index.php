<?php
     session_start();
     $ClientString = $_SERVER['HTTP_USER_AGENT'] .$_SERVER['REMOTE_ADDR'];
        if( !isset( $_SESSION['UserName']) || $_SESSION['ClientStr'] != md5(
            $ClientString))
    {
      header( "location: ../index.php" );
      exit();
    }


     if(!isset($_SESSION['Error'])){
        $_SESSION['Error']="";
     }
    if(isset($_POST['btnlogout']))
    {
        $_SESSION['UserName']=Null;    //destroy variable
        $_SESSION['Error']=Null;
        session_destroy();
        header( "location: ../index.php" );
    }
    include("functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title> Jaajoor </title>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html" charset="utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="../css/images/main.css" type="text/css" />


</head>
<body dir="ltr">
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
            <br />
        </td>


        <!-- Main -->

        <td id="Main">
        <div>
             <div class="address"><div class="name"><?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?></div>
                <pre>ايجاد موقعيت</pre>
             </div>

             <center>
                     <?php if(isset($_SESSION['position'])) echo "<div class='message'>" . $_SESSION['position'] ."</div>";  // <!--show a message from action -->
                           $_SESSION['position']="";
                     ?>
                	<fieldset dir="rtl" style="width:500px; background-color: #EAEAEA;border-radius:15px;">
						  <legend><img src="">ایجاد موقعیت</legend>
						  <form method="post" action="actions.php" enctype="multipart/form-data" >
						  <table>
							  <tbody><tr>

								  <td>نام مکان</td>
								  <td><input name="locname" id="locname" type="text" size="50"/>  <label id="locnameinfo" class="mandatory">*</label>
                                      <input name="act"  value="1" type="hidden"/>
                                      <input name="from"  value="1" type="hidden"/>
                                  </td>
							  </tr>
							  <tr>
								  <td>منطقه</td>
								  <td><select name="region">
										  <option selected="selected" value="1">منطقه 1</option>
										  <option value="2">منطقه 2</option>
										  <option value="3">منطقه 3</option>
										  <option value="4">منطقه 4</option>
										  <option value="5">منطقه 5</option>
										  <option value="6">منطقه 6</option>
										  <option value="7">منطقه 7</option>
										  <option value="8">منطقه 8</option>
										  <option value="9">منطقه 9</option>
										  <option value="10">منطقه 10</option>
										  <option value="11">منطقه 11</option>
										  <option value="12">منطقه 12</option>
										  <option value="13">منطقه 13</option>
										  <option value="14">منطقه 14</option>
										  <option value="15">منطقه 15</option>
										  <option value="16">منطقه 16</option>
										  <option value="17">منطقه 17</option>
										  <option value="18">منطقه 18</option>
                                          <option value="19">منطقه 19</option>
                                          <option value="20">منطقه 20</option>
									  </select>                                        <label id="regioninfo"  class="mandatory">*</label>
								  </td>
							  </tr>
							  <tr>
								  <td>خیابان</td>
								  <td>
      								  <select name="street" style="width: 150px;">
                                              <?php showregion(); ?>
 	    							  </select>                                        <label id="streetinfo"  class="mandatory">*</label>
                                  </td>
							  </tr>
							  <tr>
								  <td>لینک</td>
								  <td><input name="site" placeholder="www.domain.com" type="text"></td>
							  </tr>
							  <tr>
								  <td>تلفن</td>
								  <td><input name="tell" type="text"></td>
							  </tr>
							  <tr>
								  <td>فکس</td>
								  <td><input name="fax" type="text"></td>
							  </tr>
							  <tr>
								  <td>ایمیل</td>
								  <td><input name="email" placeholder="info@domain.com" type="text"></td>
							  </tr>
							  <tr>
								  <td>نام مسئول</td>
								  <td><input name="manager" type="text" size="30">    <label id="managerinfo"  class="mandatory">*</label> </td>
							  </tr>
                              <tr style="border: 1px solid #E0E0E0">
                              	<td> عکس </td>
                              	<td> عکس لوگو    <input name="logopic" type="file">       <label id="logopicinfo"  class="mandatory">*</label>
                                  <fieldset>
                                      <table>
                                       <tr>
                                          <td>عکس اول</td>
                                    	    <td><input name="pic1" type="file">          <label id="pic1info"  class="mandatory">*</label>      </td>
                                       </tr>
                                       <tr>
                                          <td>عکس دوم</td>
                                    	    <td><input name="pic2" type="file">          <label id="pic2sinfo"  class="mandatory">*</label>     </td>
                                       </tr>
                                       <tr>
                                          <td>عکس سوم</td>
                                    	    <td><input name="pic3" type="file">          <label id="pic3info"  class="mandatory">*</label>      </td>
                                       </tr>
                                      </table>

                                  </fieldset>
                                </td>
                              </tr>
							  <tr>
								  <td>آدرس</td>
								  <td><textarea cols="30" rows="4" name="address"></textarea>   <label id="streetinfo"  class="mandatory">*</label>    </td>
							  </tr>
                              <tr>
								  <td>کلمات کليدي</td>
								  <td><textarea cols="30" rows="4" name="keywords"></textarea>       <label id="streetinfo"  class="mandatory">*</label>   </td>
							  </tr>
							  <tr>
								  <td valign="top">زیر گروه ها</td>
								  <td><div >
                                          <?php showsubgroup(); ?>
                                      </div>
                				  </td>
							  </tr>
							  <tr>
								  <td></td>
								  <td>  <br />
                                        <pre>        <input name="AddLoc" value="ایجاد موقعیت" type="submit"></pre>
                                  </td>
							  </tr>
                              <tr>

                              </tr>
						  </tbody></table>
						  </form>
                    </fieldset>

            </center>
         </div>
        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>
