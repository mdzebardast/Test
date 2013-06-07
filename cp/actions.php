<? ob_start(); ?>
<? session_start(); ?>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>
<?php
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
                $User = trim($_POST['txtname']);
                $Pass = trim($_POST['txtpass']);

                $User=str_replace("'", "", $User);
                $message=login($User,$Pass);
            }
            else{
                $message="<p class='error'>لطفا نام کاربري و کلمه عبور را وارد نماييد!</p>";
            }
            $_SESSION['Error']=$message;
            redirect("index.php");

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

          redirect("register.php");

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

    if($act==1 && $from==1){          //delete record from position table
        if(isset($_POST['txtkeywords']) && isset($_POST['locname']) ){                  //is set

		   $owner_id=$_SESSION['uid']+0;
           $locname=trim($_POST['locname']);
           $region=trim($_POST['region']);
           $street=trim($_POST['street']);
           $link=trim($_POST['link']);
           $tell=trim($_POST['tell']);
           $fax=trim($_POST['fax']);
           $email=trim($_POST['email']);
           $manager=trim($_POST['manager']);
           $keywords=trim($_POST['txtkeywords']);

           $target_path="images/";
           $logopic=$target_path . time() . (rand()+1) * 127;
           $pic1=$target_path . time() . (rand()+2) * 327;
           $pic2=$target_path . time() . (rand()+3) * 427;
           $pic3=$target_path . time() . (rand()+4) * 526;

           if(move_uploaded_file($_FILES['logopic']['tmp_name'],$logopic)){
              if(move_uploaded_file($_FILES['pic1']['tmp_name'],$pic1))
              if(move_uploaded_file($_FILES['pic2']['tmp_name'],$pic2))
              if(move_uploaded_file($_FILES['pic3']['tmp_name'],$pic3))

              $logopic=trim(basename($_FILES['logopic']['name']));
              $pic1=trim(basename($_FILES['pic1']['name']));
              $pic2=trim(basename($_FILES['pic2']['name']));
              $pic3=trim(basename($_FILES['pic3']['name']));
			  if(!empty($title)){        //&& !empty($mojodi)      //is empty
                $message=regarticle($owner_id,$locname,$region,$street,$link,$tell,$fax,$email,$manager,$keywords,$logopic,$pic1,$pic2,$pic3);
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
        $_SESSION['bankMes']=$message;
        redirect("article_up.php");

    }

    if($act==2 && $from==1){          //delete record from bank table
        $id=$_REQUEST['id']+0;

        $message=delbank($id);
        $_SESSION['bankMes']=$message;
        redirect("article_up.php");

    }


//-----------------------------------------------------------assign article------------------------------------------------------------------
     if($act==1 && $from==2){          // register record from employee table
        $message="";
        if(isset($_POST['selectjudge'])){
            $judgeid=$_POST['selectjudge'];
            if($_POST['opt']){
                foreach( $_POST['opt'] as $opt)
    			{
    					$opt += 0;
    					$message=regassign($judgeid,$opt);
    			}

            }else{
            $message="<p class=error>لطفا نام را وارد نماييد!</p>";
            }
        }
        else{
           $message="<p class=error>لطفا نام را وارد نماييد!</p>";
        }
         $_SESSION['empMes']=$message;
         redirect("assign_art.php");
     }

   
//--------------------------------------------------------------judge update--------------------------------------------------------------------------------------------------
    if($act==1 && $from==3){          // register record from  table
        $message="";
        if(isset($_REQUEST['comment'])){
            $comment=trim($_REQUEST['comment']);
            $statusid=trim($_REQUEST['statusid']);
            $status=$_REQUEST['status'];

           if(!empty($comment)){
                $message=updatestatus($statusid,$comment,$status);
           }
            else{
                $message="<p class=error>لطفا توضیحات را وارد نماييد!<p>";
            }
        }else{
            $message="<p class=error>لطفا توضیحات را وارد نماييد</p>";
         }
         $_SESSION['artjudge']=$message;

     }

    if($act==1 && $from==4){     //register user

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