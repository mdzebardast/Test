<?php
   $_SESSION['uid']=1;

/*
    this file is about actions.
    action type{
        1=register
        2=delete
        3=update/redirect
        4=update
    }
    from{
    }

*/
    session_start();

    //include("config.php");
    include("functions.php");

    //This is a action file that decide
    $act=$_REQUEST['act']+0;
    $from=$_REQUEST['from']+0;
    $message="";
//------------------------------------------------------------Logins-------------------------------------------------------------------------------------------------------
       if($act==0 && $from==0){
            if(isset($_POST['txtpass'])){
                $User = mysql_real_escape_string(trim($_POST['txtname']));
                $Pass = mysql_real_escape_string(trim($_POST['txtpass']));

                $User=str_replace("'", "", $User);
                $message=login($User,$Pass);
            }
            else{
                $message="<p class='error'>لطفا نام کاربري و کلمه عبور را وارد نماييد!</p>";
            }
            $_SESSION['Error']=$message;

            redirect("../index.php");

       }
//-------------------------------------------------register user---------------------------------------------------------------------------------------------------------
      function validateuser(&$Name,&$Email,&$UN,&$Pw,&$Cpw,&$fail,&$active=1){              //validate user
        $Name=trim($_POST['Name']);
          $Email=trim($_POST['Email']);
          $UN=trim($_POST['UserName']);
          $Pw=trim($_POST['Password']);
          $Cpw=trim($_POST['ConfirmPassword']);

          //Check Empty Email and Name...
          $fail=1;
          if(empty($Name)){
                 $message="<p class='error'>لطفا نام خود را وارد نماييد</p>";
                 $fail=2;
          }
          if(empty($UN)  && $fail==1){
                 $message="<p class='error'>لطفا نام کاربري خود را وارد نماييد</p>";
                 $fail=2;
          }
          if(empty($Pw) && $fail==1){
                 $message="<p class='error'>لطفا کلمه عبور خود را وارد نماييد</p>";
                 $fail=2;
          }
          if(strlen($Pw)<6 && $fail==1){
                $message="<p class='error'>کلمه عبور شما حداقل بايد 6 کاراکتر باشد</p>";
                $fail=2;
          }
          if($Pw!=$Cpw && $fail==1){
                 $message="<p class='error'>کلمه عبور شما برابر نمي باشد</p>";
                $fail=2;
          }
          if(empty($Email) && $fail==1){
                $message="<p class='error'>لطفا ايميل خود را وارد نماييد!</p>";
                $fail=2;
          }
          //Set The special HTML Characters 2 HTML Codes
             $Name= htmlspecialchars($Name);
          //Remove Slashes...
             $Name=str_replace("'", "", $Name);
          //Convert Email Address to Lower Case
             $Email  = strtolower($Email);
             $Email=trim($Email);

          //Check For Valid Email Address Expression
                if(!preg_match("/^[.A-z0-9_-]+[@][A-z0-9_-]+([.][A-z0-9_-]+)+[A-z]{2,4}$/",$Email) && $fail==1){
                     $message="<p class='error'>ايميل نامعتبر مي باشد!</p>";
                     $fail=2;
                }
          return $message;
      }

  if($act==1 && $from==0){     //register user

          $fail=1;
          $message=validateuser($Name,$Email,$UN,$Pw,$Cpw,$fail,$active);

          if($fail==2){
              $_SESSION['regMes']=$message;
          }elseif($fail==1){
              $_SESSION['regMes']=registerUser($Name,$Email,$UN,$Pw);
          }

          redirect("../users.php");

      }

      if($act==2 && $from==0){          //delete record from users table
        $id=$_REQUEST['id']+0;

        $message=deluser($id);
        $_SESSION['regMes']=$message;
        redirect("register.php");

    }

    if($act==3 && $from==0){          //update record from users table .it just redirect
        $id=$_REQUEST['id']+0;
        redirect("editregister.php?id=$id");
    }
     if($act==4 && $from==0){          //update and register record from users table
        $id=$_POST['id']+0;
         $fail=1;
         $active=$_POST['active'];
         $type=$_POST['type'];
         $message=validateuser($Name,$Email,$UN,$Pw,$Cpw,$fail,$active);         //validate user

          if($fail==2){
              $_SESSION['regMes']=$message;
          }elseif($fail==1){
              $message=updateuser($id,$Name,$Email,$UN,$Pw,$active,$type);
          }
        $_SESSION['regMes']=$message;
        redirect("register.php");
    }


//------------------------------------------------------------position------------------------------------------------------------------------------------------------------

    if($act==1 && $from==1){          //insert record --position table
        if(isset($_POST['keywords']) /*&& isset($_POST['locname']) && isset($_POST['address']) && isset($_POST['logopic'])*/ ){                  //is set

           $valid_formats = array("jpg", "png", "gif", "bmp");
           $target_path="../images/";

		   $owner_id=$_SESSION['uid']+0;
           $locname=mysql_real_escape_string(trim($_POST['locname']));
           $region=mysql_real_escape_string(trim($_POST['region']));
           $street=mysql_real_escape_string(trim($_POST['street']));
           $link=mysql_real_escape_string(trim($_POST['link']));
           $site=mysql_real_escape_string(trim($_POST['site']));
           $tell=mysql_real_escape_string(trim($_POST['tell']));
           $fax=mysql_real_escape_string(trim($_POST['fax']));
           $email=mysql_real_escape_string(trim($_POST['email']));
           $manager=mysql_real_escape_string(trim($_POST['manager']));
           $address=mysql_real_escape_string(trim($_POST['address']));
           $keywords=mysql_real_escape_string(trim($_POST['keywords']));
           $subgroups=mysql_real_escape_string($_POST['subgroups']);


     		list($txt, $extlogo) = explode(".", $_FILES['logopic']['name']);
     		list($txt, $ext1) = explode(".", $_FILES['pic1']['name']);
     		list($txt, $ext2) = explode(".", $_FILES['pic2']['name']);
     		list($txt, $ext3) = explode(".", $_FILES['pic3']['name']);
            $sizelogo=$_FILES['logopic']['size'];
            $size1=$_FILES['pic1']['size'];
            $size2=$_FILES['pic2']['size'];
            $size3=$_FILES['pic3']['size'];

            $logopic= time() . (rand()+1) * 127 . "." . $extlogo;
           $pic1= time() . (rand()+2) * 327 . "." . $ext1;
           $pic2= time() . (rand()+3) * 427 . "." . $ext2;
           $pic3= time() . (rand()+4) * 526 . "." . $ext3;

            $uploadable=false;
	    	if(in_array($extlogo,$valid_formats) && in_array($ext1,$valid_formats) && in_array($ext2,$valid_formats) && in_array($ext3,$valid_formats)){
                if($sizelogo<(1024*1024) && $size1<(1024*1024) && $size2<(1024*1024) && $size3<(1024*1024)){
                      $uploadable=true;
                }
	    	}

           if($uploadable && move_uploaded_file($_FILES['logopic']['tmp_name'],$target_path . $logopic) ){
              if(move_uploaded_file($_FILES['pic1']['tmp_name'],$target_path . $pic1))
              if(move_uploaded_file($_FILES['pic2']['tmp_name'],$target_path . $pic2))
              if(move_uploaded_file($_FILES['pic3']['tmp_name'],$target_path . $pic3))

    		    $image = new FN_Image;
                $image->Thumbnail($target_path . $logopic,'',$target_path . 'mz_' . $logopic , 100,100, false);   //create a thumb picuture
                $image->Thumbnail($target_path . $pic1,'',$target_path . 'mz_' . $pic1 , 618,246, false);   //create a thumb picuture
                $image->Thumbnail($target_path . $pic2,'',$target_path . 'mz_' . $pic2 , 618,246, false);   //create a thumb picuture
                $image->Thumbnail($target_path . $pic3,'',$target_path . 'mz_' . $pic3 , 618,246, false);   //create a thumb picuture

                unlink($target_path . $logopic);     //remove original file
                unlink($target_path . $pic1);     //remove original file
                unlink($target_path . $pic2);     //remove original file
                unlink($target_path . $pic3);     //remove original file

              $logopic=trim(basename('mz_'. $logopic));
              $pic1=trim(basename('mz_' . $pic1));
              $pic2=trim(basename('mz_' . $pic2));
              $pic3=trim(basename('mz_' . $pic3));
			  if(!empty($locname) && !empty($region) && !empty($street) && !empty($manager) && !empty($address) && !empty($keywords)){             //is empty
                    $message=regposition($owner_id,$locname,$region,$street,$link,$site,$tell,$fax,$email,$manager,$address,$keywords,$subgroups,$logopic,$pic1,$pic2,$pic3);
              }
              else{
                	$message="<p class=error>لطفا عنوان و کلمه کلیدی و فایل مورد نظر را وارد نماييد!</p> ";         //send a message
              }
           }else{
                echo "در آپلود کردن فايل مشکل پيش آمده است";
            }
           //$date=$_POST['txtdate'];

        }
        else{
            $message="<p class=error>لطفا عنوان و کلمه کلیدی و فایل مورد نظر را وارد نماييد!</p> ";     //send a message to the page that send this datums
        }
        $_SESSION['position']=$message;
        redirect("index.php");

    }

    if($act==2 && $from==1){          //delete record from bank table
        $id=$_REQUEST['id']+0;

        $message=delbank($id);
        $_SESSION['bankMes']=$message;
        redirect("article_up.php");

    }

     if($act==3 && $from==2){  //show position
         if(isset($_POST['positionname'])){
            $positionname=mysql_real_escape_string(trim($_POST['positionname']));
            $street=mysql_real_escape_string(trim($_POST['streetname']));
            $streetid=intval(mysql_real_escape_string(trim($_POST['streetid'])));
            $groupid=intval(mysql_real_escape_string(trim($_POST['groupid'])));

            showposition($positionname,$street,$streetid,$groupid);
     }
    }
//------------------------------------------Street-------------------------------------------------------------------------------------------------
    if($act==1 && $from==3){          //insert record street
    if(isset($_POST['txtname'])){
        $streetname=mysql_real_escape_string(trim($_POST['txtname']));

        $message=regstreet($streetname);
    }else{
        $message='لطفا نام خيابان را را وارد نمايياد';
    }
        $_SESSION['street']=$message;
        redirect("street.php");

    }
    if($act==2 && $from==3){          //delete record from bank table
        $id=$_REQUEST['id']+0;
        $uid=$_SESSION['uid'];

        $message=delstreet($id, $uid);
        $_SESSION['streetmes']=$message;
        redirect("street.php");

    }

    if($act==3 && $from==3){          //update record from bank table .it just redirect
        $id=$_REQUEST['id']+0;
        redirect("editstreet.php?id=$id");
    }
     if($act==4 && $from==4){          //update and register record from bank table
        $id=$_POST['id']+0;
        $uid=$_SESSION['uid'];
        if(isset($_POST['txtname'])){                  //is set

           $name=trim($_POST['txtname']);
           //$date=$_POST['txtdate'];
           if(!empty($name)){              //is empty
               $message=updatestreet($name,$id,$uid);
           }
     }
        $_SESSION['streetmes']=$message;
        redirect("street.php");
    }

//------------------------------------------group-------------------------------------------------------------------------------------------------
    if($act==1 && $from==5){          //insert record group
    if(isset($_POST['txtname'])){
        $groupid=mysql_real_escape_string(trim($_POST['groupid']));
        $subgroupname=mysql_real_escape_string(trim($_POST['txtname']));

        $message=reggroup($groupid,$subgroupname);
    }else{
        $message='لطفا نام را وارد نماييد';
    }
        $_SESSION['group']=$message;
        redirect("group.php");

    }
    if($act==2 && $from==5){          //delete record from group table
        $id=$_REQUEST['id']+0;
        $uid=$_SESSION['uid'];

        $message=delgroup($id, $uid);
        $_SESSION['group']=$message;
        redirect("group.php");

    }

    if($act==3 && $from==5){          //update record from bank table .it just redirect
        $id=$_REQUEST['id']+0;
        redirect("editgroup.php?id=$id");
    }
     if($act==4 && $from==5){          //update and register record from bank table
        $id=$_POST['id']+0;
        $uid=$_SESSION['uid'];
        if(isset($_POST['txtname'])){                  //is set

           $name=trim($_POST['txtname']);
           $parentid=trim($_POST['$parentid']);
           //$date=$_POST['txtdate'];
           if(!empty($name)){              //is empty
               $message=updategroup($name,$id,$uid);
           }
     }
        $_SESSION['group']=$message;
        redirect("group.php");
    }
//-------------------------------------------------Position delete ----------------------------------------------------------------------------------
    if($act==2 && $from==6){          //delete record from group table
        $id=$_REQUEST['id']+0;
        $uid=$_SESSION['uid'];

        $message=delposition($id, $uid);
        $_SESSION['position']=$message;
        //redirect("editposition.php");

    }
//--------------------------------------------------------------judge update--------------------------------------------------------------------------------------------------

    if($act==1 && $from==10){     //register user

          $fail=1;
          $message=validateuser($Name,$Email,$UN,$Pw,$Cpw,$fail,$active);

          if($fail==2){
              $_SESSION['reguser']=$message;
              redirect("users.php");
          }elseif($fail==1){
              $_SESSION['reguser']=registerUser($Name,$Email,$UN,$Pw);
              redirect("users.php");
          }
      }

?>