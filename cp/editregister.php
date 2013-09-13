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
     include("functions.php");
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query="SELECT name,email,username,pass,active,`type` FROM users  WHERE uid='$id'";
       $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if(mysql_affected_rows()){
           $row=mysql_fetch_array($Result);
           $name=$row['name'];
           $username=$row['username'];
           $email=$row['email'];
           $pass=$row['pass'];
           $active=$row['active']+0;
           $type=$row['type']+0;  //type of user
           $act=$disact="";
           if($active==1){
                $act='selected=""';
           }
           else{
                $disact='selected=""';
            }
          $user=$judge=$admin="";
            if($type==1){
                $user='selected=""';
           }elseif($type==2){
                $judge='selected=""';
           }elseif($type==3){
                $admin='selected=""';
           }
        }
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META http-equiv="Content-Language" content="fa">
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="../css/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/images/main.css" type="text/css" />


    <title>ويرايش کاربر</title>

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
            <center><br/><div  class="">
                <form  method="POST" action="actions.php">
                       <table >
                            <tr> <td class="titletd"><p>نام :    </td><td> <input type="text" name="Name"  size="20" value="<?php echo $name?>"></p></td></tr>
                            <tr> <td class="titletd"><p>  نام کاربري :    </td>    <td> <input type="text" name="UserName"  size="20" value="<?php echo $username?>"></p></td></tr>
                            <tr> <td class="titletd"><p> کلمه عبور :    </td>    <td> <input type="password" name="Password"  size="32" value="<?php echo $pass?>"> <small class="error">در صورت عدم تمايل به تغيير کلمه عبور لطفا محتويات فيلدهاي کلمه عبور را تغيير ندهيد!</small></p></td></tr>
                            <tr> <td class="titletd"><p> تکرار کلمه عبور :    </td>    <td> <input type="password" name="ConfirmPassword"  size="32" value="<?php echo $pass?>"></p></td></tr>
                           <tr><td class="titletd"><p>ايميل :</td><td> <input type="text" name="Email" size="20" value="<?php echo $email?>"  onblur="validate(this.value)"> </td></tr></p>
                           <tr><td class="titletd">وضعيت:</td>    <td><select  name="active">
                                <option value="1" <?php echo $act?>>فعال</option>
                                <option value="0" <?php echo $disact?>>غير فعال</option> </select>       </td> </tr>

                           <tr><td class="titletd">وضعيت دسترسي:</td>    <td><select  name="type">
                                <option value="1" <?php echo $user?>>کاربر</option>
                                <option value="3" <?php echo $admin?>>مدير</option></select>       </td> </tr>

                            <input type="hidden" name="from"  value="0"/>
                            <input type="hidden" name="act"  value="4"/>
                            <input type="hidden" name="id"  value="<?php echo $id?>"/>
                            <tr><TD><br /></TD><td></td></tr>
                             <tr><td></td><td> <p><input type="submit" value="ويرايش" name="register" class="btn" onclick="validate()"></p></td><td><a href="register.php"> <img src='./theme/back.png' ></a></td></tr>
                       </table>
                </form>
                <div id="message"><?php echo $_SESSION['regMes']; $_SESSION['regMes']=""; ?></div>
            </div></center>

        </td>

         <!-- Left -->
        <td id="Left"></td>


        </table>

    </center>
</body>
</html>


