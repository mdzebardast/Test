<?php

    include("config.php");
//    include("jdf.php");

 //------------------------------------------------------------------------------------------------------------------------------------------------------------
    function redirect($addr){
        @header("location:".$addr);
    }
 //-------------------------------------------------------------------------------------Login-------------------------------------------------------------------------
    function login($User,$Pass){
          //Checking the user and pass...
           $sql = "SELECT `pass`,`uid`,`type`,`name`   FROM `users`
                   WHERE `username` = '$User' AND active=1" ;

                  mysql_query('SET NAMES UTF8');
                  $Result = mysql_query($sql);
                  $Pass=md5($Pass);
                  $row=mysql_fetch_array($Result);
                  if(mysql_num_rows($Result) == 1 && $row['pass'] == $Pass)
                  {
                     $_SESSION['UserName'] = $User;

                     $ClientString = $_SERVER['HTTP_USER_AGENT'] .$_SERVER['REMOTE_ADDR'];
                     $_SESSION['ClientStr'] = md5($ClientString);
                     $_SESSION['uid']=$row['uid'];
                     $_SESSION['type']=$row['type'];
                     $_SESSION['name']=$row['name'];
                     $message="<p >خوش آمديد!</p>";
                     //loginshow();      //show exit button(LogOut)
                  }
                  else
                  {
                      $message="<p class='error'>نام کاربري وکلمه عبور شما اشتباه مي باشد!</p>";
                  }
              return $message;

    }   //end function
   function  loginshow(){
        if(isset($_SESSION['UserName'])){
                  echo "<form method='post' action='index.php' ><tr><td><li><input type='submit' value='خروج' class='logout' name='btnlogout'/></li></td></tr></form>";
        }
    }
    function registerUser($Name,$Email,$UN,$Pw){
           //Check Exist...
           $fail=1;    //correct
           $Sql = "SELECT COUNT(*) FROM `users` WHERE `username` = '$UN'";
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
           if(mysql_result($Result, 0) > 0 ){
               $message="<p class='error'>اين نام کاربري قبلا ثبت شده است!</p>";
               $fail=2;
           }
           //check username
           if($fail==1){
                $Sql = "SELECT COUNT(*) FROM `users` WHERE `email` = '$Email'";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
                if(mysql_result($Result, 0) > 0 ){
                    $message="<p class='error'>اين ايميل قبلا ثبت شده است!</p>";
                    $fail=2;
                }
          }//second end if

           //Create A Random Security Code...
           $RandomNum = rand(0, 9999);
           $SecCode =  md5($RandomNum);
           $Pw=md5($Pw);
           if($fail==1){
               //Insert New User...
               $Sql = "INSERT INTO `users` (`email`, `name`,`UserName`,`Pass`, `active`, `join_date`, `sec_code`)
                   VALUES
                       ('$Email', '$Name','$UN','$Pw',1, CURRENT_TIMESTAMP, '$SecCode')";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
                $message="ثبت با موفقيت انجام شد";
           }

           return $message;
    }
    function showuser(){
              $query="SELECT uid,name,email,username,active,join_date,type FROM users ORDER BY name";
              mysql_query('SET NAMES UTF8');
              $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

              echo "<table  class='bank'><tr class='headtr'> <td >نام</td> <td >نام کاربري</td> <td>ايميل</td><td>تاريخ عضويت</td><td>نوع کاربري</td> <td>وضعيت</td><td>ويرايش</td><td>حذف</td></tr>";
              $i=0;
              while ($row=mysql_fetch_array($Result)){
                   if($i%2==0){
                        echo '<tr class="whitetr">';
                        }
                   else{
                    echo "<tr class='inter'>";                                                         //change background
                   }

                    print('<td><label>'.$row['name'].' </label></td>');                                          //show title
                    print('<td><label>'.$row['username'].' </label></td>');                                          //show username
                    print('<td><label>'.$row['email'].' </label></td>');

                    list($gYear,$gMonth,$gDay) = explode("-",$row['join_date']);                       //convert date to shamsi
			        list($jYear,$jMonth,$jDay) = gregorian_to_jalali((int)$gYear, (int)$gMonth, (int)$gDay);
                    print('<td><label> '.$jYear."/".$jMonth."/".$jDay." </label></td>");                //show date

                    if($row['type']==1){
                        echo('<td><label>کاربر</label></td>');                                          //show type
                    }
                    else{
                        echo('<td><label>داور</label></td>');                                          //show type
                    }

                    if($row['active']==1){
                        echo('<td><label>فعال</label></td>');                                          //show status
                    }
                    else{
                        echo('<td><label>غيرفعال</label></td>');                                          //show status
                    }
                    echo "<td> <a href=actions.php?from=0&act=3&id=$row[uid]> <img  class='update'></a></td>";   //update
                    echo "<td> <a onclick=resure('actions.php?from=0&act=2&id=$row[uid]');return false;> <img  class='delete'></a></td>";   //delete


                    $i++;
                    echo "</tr>";
                }//End While
               echo "</table>" ;
    }
      function deluser($id){
        $message="";
        $query="DELETE FROM users Where uid=$id";
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if( mysql_affected_rows()){
            $message="با موفقيت حذف شد";
        }else {
            $message="<p class=error>حذف نشد!<p> ";
        }
          return $message;
    }

     function updateuser($id,$name,$email,$un,$pw,$active,$type){
           $fail=1;    //correct
           $Sql = "SELECT COUNT(*) FROM `users` WHERE uid!=$id AND `username` = '$un' ";
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
           if(mysql_result($Result, 0) !=0 ){
               $message="<p class='error'>اين نام کاربري قبلا ثبت شده است!</p>";
               $fail=2;
           }
           if($fail==1){      //check email
               $Sql = "SELECT COUNT(*) AS count FROM `users` WHERE uid!=$id AND `email` = '$email'";   //check email is repeated
               mysql_query('SET NAMES UTF8');
               $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
               if(mysql_result($Result, 0)!=0 ){
                   $message="<p class='error'>اين ايميل قبلا ثبت شده است!</p>";
                   $fail=2;  //There is an error //repeated email
               }
           }
           ////check password is changed  .......................................
           $Sql = "SELECT COUNT(*) FROM `users` WHERE `pass` = '$pw' AND uid=$id";   //check password is changed
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);

           if(mysql_result($Result,0)==0){  //
                $pw=md5($pw);
           }

           if($fail==1){
               $query="UPDATE users SET name='$name',email='$email',username='$un',pass='$pw',active=$active,`type`=$type WHERE uid='$id'";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
                if(mysql_affected_rows()){
                    $message="ويرايش با موفقيت انجام شد";
                }else{
                    $message="ويرايشي انجام نشد!";
                }
            }
        return $message;
     }
//-----------------------------------------------------------------------------------------------------------------------------------------------------
    function showregion(){
    try{
        $query="SELECT * FROM street";
        mysql_query('SET NAMES UTF8');
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        $i=0;
        while ($row=mysql_fetch_array($Result)){
          if($i==0){
             echo '<option selected="selected" value="' . $row['sid'] . '">' . $row['name'] . '</option>';
             $i++;
          }else{
             echo '<option value="' . $row['sid'] . '">' . $row['name'] . '</option>';
          }

        }
        mysql_free_result($Result);

    }catch(Exception $e){
        echo e.getMessage();
    }

    }

//-----------------------------------------------------------------article-----------------------------------------------------------------------------------------

?>